<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 3.2
 *   LICENSE: http://buyscripts.in/vshare-license
 *   WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require '../include/config.php';
require './inc/functions_upgrade.php';
$html_title = 'VSHARE UPGRADE';
require './tpl/header.php';

if ($config['version'] != '20070625')
{
    die('<p>This upgrade script can only upgrade if you are using version: 20070625</p>');
}

write_log('#### UPGRADE 20070625 to 20070712 STARTED ####', 'vshare_upgrade', 0,'txt');

$sql = "UPDATE `sconfig` SET 
       `svalue`='20070712' WHERE 
       `soption` = 'version'";
$result = mysql_query($sql) or mysql_die();

write_log('#### UPGRADE 20070625 to 20070712 FINISHED ####', 'vshare_upgrade', 0,'txt');

upgrade_next_step("20070712");