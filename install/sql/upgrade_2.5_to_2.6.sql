CREATE TABLE `servers` (`id` int(11) NOT NULL auto_increment,`ip` varchar(255) NOT NULL,`url` varchar(255) NOT NULL,`user_name` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,`folder` varchar(255) NOT NULL,`status` int(1) NOT NULL default '0',`space_used` int(11) unsigned NOT NULL default '0', PRIMARY KEY  (`id`));
CREATE TABLE `tags` (`id` int(11) NOT NULL auto_increment,`tag` varchar(255) NOT NULL,`tag_count` int(11) NOT NULL default '0',`used_on` int(11) NOT NULL default '0',`active` int(1) NOT NULL default '1', PRIMARY KEY  (`id`));
CREATE TABLE `tag_video` (`id` int(11) NOT NULL auto_increment, `tag_id` int(11) NOT NULL, `vid` int(11) NOT NULL, `chid` varchar(255) NOT NULL, PRIMARY KEY  (`id`));
UPDATE `sconfig` SET `soption` = 'player_width' WHERE `soption` = 'player_wdith';
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES ('video_comments_per_page', '5');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES ('user_comments_per_page', '5');
INSERT INTO `sconfig` (`soption`, `svalue` ) VALUES ('num_new_videos', '4');
INSERT INTO `sconfig` (`soption`, `svalue` ) VALUES ('num_watch_videos', '12');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('video_duration_cmd', '0');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('editor_wysiwyg_admin', '1');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('editor_wysiwyg_email', '1');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('mail_abuse_report', '1');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('signup_auto_friend', '');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('enable_flvtool', '0');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('video_flv_delete', '1');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('video_source_delete', '0');
ALTER TABLE `video` ADD `server_id` INT( 1 ) DEFAULT '0' NOT NULL AFTER `adult` ;
ALTER TABLE `video` ADD `vtype` INT( 2 ) NOT NULL AFTER `type`;
ALTER TABLE `video` DROP `vkey`;
ALTER TABLE `video` ADD `embed_code` TEXT AFTER `embed` ;
ALTER TABLE `process_queue` CHANGE `description` `description` TEXT NOT NULL;
INSERT INTO `emailinfo` VALUES ('abuse_report', 'Abuse report on [VIDEO_TITLE]', '<p>Hi Admin,</p>  <p>Following video is reported as Inappropriate.</p><p><a href="[VIDEO_URL] ">[VIDEO_URL]</a></p><p>Abuse Type: <font color="#000000">[TYPE_ABUSE]</font></p><p>Comments: <font color="#000000">[ABUSE_COMMENTS]</font></p><p>Reported by:</p><p>User Name: [USER_NAME]<br />IP Address: &nbsp;[REMOTE_ADDR]</p><p>Thanks,</p><p><a href="[SITE_URL]">[SITE_NAME]</a></p>', 'Report Inappropriate Video');
INSERT INTO `emailinfo` VALUES ('delete_user', '[SITE_NAME] Account Delete Verification - [USERNAME]', '<p>Hi [USERNAME],</p><p>You or some one from IP: [USER_IP] requested to delete the account [USERNAME]</p><p><a href="[SITE_URL]/[USERNAME]">[SITE_URL]/[USERNAME]</a></p><p>To delete the account, click the link below</p><p><a href="[VERIFY_URL]">[VERIFY_URL]</a></p><p>Thank you,</p><p><a href="[SITE_URL]">[SITE_NAME]</a></p>', 'Account delete verification Mail');
UPDATE `sconfig` SET `svalue` = '2.6' WHERE `soption` = 'version';