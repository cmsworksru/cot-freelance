<?php
/**
 * Update to v. 1.1.4:
 */

defined('COT_CODE') or die('Wrong URL');

Cot::$db->query('ALTER TABLE '. Cot::$db->users . ' MODIFY user_referal INT UNSIGNED NOT NULL DEFAULT 0');