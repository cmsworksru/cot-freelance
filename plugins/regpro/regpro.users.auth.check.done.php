<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
 * [END_COT_EXT]
 */

/**
 * @var array $row User data
 */

defined('COT_CODE') or die('Wrong URL.');

if (Cot::$cfg['plugin']['regpro']['protime'] > 0) {
	require_once cot_langfile('regpro', 'plug');

	if ($row['user_logcount'] == 1) {
		$upro = cot_getuserpro($row['user_id']);
		$initialtime = ($upro > Cot::$sys['now']) ? $upro : Cot::$sys['now'];
		$rproexpire = $initialtime + Cot::$cfg['plugin']['regpro']['protime'] * 24 * 60 * 60;

		if (
            Cot::$db->update(Cot::$db->users,  ['user_pro' => (int) $rproexpire], 'user_id = ' . $row['user_id'])
        ) {
			cot_mail(
                $row['user_email'],
                Cot::$L['regpro_mail_subject'],
                sprintf(Cot::$L['regpro_mail_body'], $row['user_name'])
            );
			cot_log("Pro for register");

            /* === Hook === */
            foreach (cot_getextplugins('regpro.done') as $pl) {
                include $pl;
            }
            /* ===== */
		}
	}
}
