<?php
/**
 * Update to v. 1.0.2:
 */

defined('COT_CODE') or die('Wrong URL');

Cot::$db->query('ALTER TABLE ' . Cot::$db->users . ' MODIFY user_detailcounts INT NOT NULL DEFAULT 0');