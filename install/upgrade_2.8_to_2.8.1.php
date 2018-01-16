<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: 3.2
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

$html_title = 'VSHARE UPGRADE';
require '../include/config.php';
require './inc/class.sql_import.php';
require './inc/functions_upgrade.php';
require './tpl/header.php';

if ($config['version'] != '2.8')
{
    die('<p>This upgrade script can only upgrade if you are using version: 2.8</p>');
}

write_log('#### UPGRADE 2.8 to 2.8.1 STARTED ####', 'vshare_upgrade', 0, 'txt');

$sql_file = VSHARE_DIR . '/install/sql/upgrade_2.8_to_2.8.1.sql';
$sql_import = new Sql2Db($sql_file);
$sql_import->import();

write_log('#### UPGRADE 2.8 to 2.8.1 FINISHED ####', 'vshare_upgrade', 0, 'txt');

upgrade_next_step("2.9");
