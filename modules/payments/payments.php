<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

declare(strict_types=1);

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, Alexey Kalnov https://lily-software.com
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

$paymentsUseOldRouter = !empty($m) && in_array($m, ['billing', 'balance', 'error'], true);

if (!$paymentsUseOldRouter) {
    Cot::$out['subtitle'] = Cot::$L['payments_mybalance'];

    if (empty($m)) {
        // Default controller
        $m = 'main';
    }

    $controllerClassName = '\\cot\\modules\\payments\\controllers\\' . ucfirst($m) . 'Controller';
    if (!class_exists($controllerClassName)) {
        // Error page
        cot_die_message(404);
        exit;
    }

    /* Create the controller */
    $controller = new $controllerClassName();

    /* Perform the Request task */
    $outContent = '';
    $actionExists = false;
    if (!empty($a)) {
        $controllerAction = lcfirst(str_replace('-', '', ucwords($a, '-'))) . 'Action';
        if (method_exists($controller, $controllerAction)) {
            $actionExists = true;
            $outContent = $controller->$controllerAction();
        }
    } elseif (method_exists($controller, 'indexAction')) {
        $actionExists = true;
        $outContent = $controller->indexAction();
    }

    if (!$actionExists) {
        cot_die_message(404);
        exit;
    }

    if (COT_AJAX) {
        echo $outContent;
        return;
    }

    if (!isset(Cot::$out['head'])) {
        Cot::$out['head'] = '';
    }
    Cot::$out['head'] .= Cot::$R['code_noindex'];

    require_once Cot::$cfg['system_dir'] . '/header.php';
    echo $outContent;
    require_once Cot::$cfg['system_dir'] . '/footer.php';

    return;
}

// old router

if (!in_array($m, ['billing', 'balance', 'error'])) {
	$msg = 1;
	$m = 'error';
}

Cot::$out['subtitle'] = Cot::$L['payments_mybalance'];

$module_body = '';

require_once cot_incfile('payments', 'module', $m);

require_once Cot::$cfg['system_dir'] . '/header.php';
echo $module_body;
require_once Cot::$cfg['system_dir'] . '/footer.php';