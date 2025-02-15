<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.mainpanel
Order=1
[END_COT_EXT]
==================== */

use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\users\UsersRepository;

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('bstat', 'plug');

$tt = new XTemplate(cot_tplfile('bstat.admin.home.mainpanel', 'plug'));

if(!empty($cfg['plugin']['bstat']['period']))
{
	switch ($cfg['plugin']['bstat']['period']){
		case 'week':
			$mindate = $sys['now'] - 7*24*60*60;
			break;
		
		case 'month':
			$mindate = $sys['now'] - 30*24*60*60;
			break;
		
		case 'year':
			$mindate = $sys['now'] - 365*24*60*60;
			break;
		
		default :
			$mindate = $db->query("SELECT pay_adate FROM $db_payments WHERE pay_status='done' AND pay_area='balance' ORDER BY pay_adate ASC")->fetchColumn();
	}

	$mindate = mktime( 0, 0, 0, cot_date('m', $mindate), cot_date('d', $mindate), cot_date('Y', $mindate) );

	$maxdate = $sys['now'];
	$maxdate = mktime( 23, 59, 59, cot_date('m', $maxdate), cot_date('d', $maxdate), cot_date('Y', $maxdate) );

	$day = $mindate;
	while($day <= $maxdate){
		$nextday = $day + 24*60*60;
		$paysumm[$day]['debet'] = $db->query("SELECT SUM(pay_summ) FROM $db_payments WHERE pay_status='done' AND pay_area='balance' AND pay_desc='Пополнение счета' AND pay_summ>0 AND pay_adate >= ".$day." AND pay_adate < ".$nextday)->fetchColumn();
		$paysumm[$day]['credit'] = $db->query("SELECT SUM(pay_summ) FROM $db_payments WHERE pay_status='done' AND pay_area='balance' AND pay_summ<0 AND pay_adate >= ".$day." AND pay_adate < ".$nextday)->fetchColumn();
		$day = $nextday;
	}

	if(is_array($paysumm)){
		foreach($paysumm AS $day => $summ){
			$tt->assign(array(
				'PAY_ROW_DEBET_SUMM' => (!empty($summ['debet'])) ? $summ['debet'] : 0,
				'PAY_ROW_CREDIT_SUMM' => (!empty($summ['credit'])) ? abs($summ['credit']) : 0,
				'PAY_ROW_DAY' => $day,
			));
			$tt->parse('MAIN.PAY_ROW');
		}
	}
}

$sql = 'SELECT SUM(pay_summ) AS summ, pay_userid as userId FROM ' . Cot::$db->payments
    . " WHERE pay_area = '" . PaymentDictionary::PAYMENT_SOURCE_BALANCE . "'"
    . " AND pay_status = '" . PaymentDictionary::STATUS_DONE . "'"
    . " GROUP BY pay_userid HAVING SUM(pay_summ) > 0 ORDER BY summ DESC LIMIT 300";

$balances = Cot::$db->query($sql)->fetchAll();

$users = [];
if (!empty($balances)) {
    $userIds = [];
    foreach($balances AS $balance) {
        if (!in_array($balance['userId'], $userIds)) {
            $userIds[] = (int) $balance['userId'];
        }
    }
    if ($userIds !== []) {
        $tmp = UsersRepository::getInstance()->getByCondition(
            ['user_id IN (' . implode(',', $userIds) . ')']
        );
        foreach ($tmp AS $user) {
            $users[$user['user_id']] = $user;
        }
    }
}

$jj = 0;
$summ = 0;

if (!empty($balances)) {
    foreach($balances AS $balance) {
        $jj++;

        $userData = (!empty($users[$balance['userId']])) ? $users[$balance['userId']] : [];

        $tt->assign(cot_generate_usertags($userData, 'BAL_ROW_USER_'));

        $tt->assign([
            'BAL_ROW_SUMM' => $balance['summ'],
            "BAL_ROW_ODDEVEN" => cot_build_oddeven($jj)
        ]);

        $summ += $balance['summ'];

        $tt->parse('MAIN.BAL_ROW');
    }
}

// @todo Это неверно т.к. в выборке выше есть технический лимит
$tt->assign('BAL_SUMM', $summ);

$tt->parse('MAIN');
$line = $tt->text('MAIN');
