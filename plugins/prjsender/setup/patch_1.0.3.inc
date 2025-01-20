<?php
/**
 * Update to v. 1.0.3:
 */

defined('COT_CODE') or die('Wrong URL');

Cot::$db->query(
    'ALTER TABLE ' . Cot::$db->users . ' MODIFY user_prjsenderdate INT NOT NULL DEFAULT 0; '
    . 'ALTER TABLE ' . Cot::$db->users . ' MODIFY user_prjsendercats MEDIUMTEXT NOT NULL DEFAULT NULL;'
);