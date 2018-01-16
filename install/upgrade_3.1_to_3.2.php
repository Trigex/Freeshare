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

if ($config['version'] != '3.1')
{
    die('<p>This upgrade script can only upgrade if you are using version: 3.1</p>');
}

write_log('#### UPGRADE 3.1 to 3.2 STARTED ####', 'vshare_upgrade', 0, 'txt');

$sql_file = VSHARE_DIR . '/install/sql/upgrade_3.1_to_3.2.sql';
$sql_import = new Sql2Db($sql_file);
$sql_import->import();

$logo_url_md = $config['baseurl'] . '/themes/default/images/logo.png';
$logo_url_sm = $config['baseurl'] . '/themes/default/images/logo-small.png';
$watermark_image_url = $config['baseurl'] . '/themes/default/images/watermark.png';

$sql = "UPDATE `sconfig` SET
       `svalue`='" . DB::quote($logo_url_md) . "' WHERE
       `soption`='logo_url_md'";
DB::query($sql);

$sql = "UPDATE `sconfig` SET
       `svalue`='" . DB::quote($logo_url_sm) . "' WHERE
       `soption`='logo_url_sm'";
DB::query($sql);

$sql = "UPDATE `sconfig` SET
       `svalue`='" . DB::quote($watermark_image_url) . "' WHERE
       `soption`='watermark_image_url'";
DB::query($sql);

write_log('#### UPGRADE 3.1 to 3.2 FINISHED ####', 'vshare_upgrade', 0, 'txt');

upgrade_next_step();
