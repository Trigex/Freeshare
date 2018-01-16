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

$html_title = 'VSHARE UPGRADE';
require '../include/config.php';
require './inc/functions_upgrade.php';
require './tpl/header.php';

if ($config['version'] != '20070730') {
    die('<p>This upgrade script can only upgrade if you are using version: 20070730</p>');
}

# upgrade from 20070730 to 2.4

write_log('#### UPGRADE 20070730 to 2.4 STARTED ####', 'vshare_upgrade', 0,'txt');

$sql = "INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'embed_show', '1')";
DB::query($sql);

$sql = "INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'embed_type', '1')";
DB::query($sql);

$sql = "INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'allow_download', '0')";
DB::query($sql);

$sql = "CREATE TABLE `verify_code` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
`vkey` VARCHAR( 255 ) NOT NULL ,
`data1` VARCHAR( 255 ) NOT NULL ,
`data2` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `id` )
);";

DB::query($sql);

$sql = "CREATE TABLE `config` (
  `config_name` varchar(255) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  PRIMARY KEY  (`config_name`)
);";

DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ( 'cron', '1');";
DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ( 'admin_listing_per_page', '20');";
DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ( 'php_path', '/usr/bin/php');";
DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ( 'home_num_tags', '20');";
DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('process_upload', '1');";
DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('process_notify_user', '1');";
DB::query($sql);

$sql = "INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('num_last_users_online', '5');";
DB::query($sql);

$sql = "CREATE TABLE `process_queue` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `channels` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `url` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `vid` int(11) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);";

DB::query($sql);

$sql = "UPDATE `sconfig` SET `svalue` = '2.4' WHERE `soption` = 'version'";
DB::query($sql);

write_log('#### UPGRADE 20070730 to 2.4 FINISHED ####', 'vshare_upgrade', 0,'txt');

upgrade_next_step("2.4");
