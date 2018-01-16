ALTER TABLE `packages` ADD `package_allow_download` INT( 11 ) NOT NULL DEFAULT '0';
UPDATE `config` SET `config_name` = 'flv_metadata',`config_value` = 'flvtool' WHERE `config_name` = 'enable_flvtool' LIMIT 1 ;
ALTER TABLE `import_track` ADD `import_track_video_id` INT( 11 ) NOT NULL AFTER `import_track_unique_id`;
ALTER TABLE `process_queue` ADD `import_track_id` INT( 11 ) NOT NULL AFTER `process_queue_upload_ip`;
ALTER TABLE `users` ADD `user_friend_invition` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_private_message` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_profile_comment` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_favourite_public` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_playlist_public` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `users` ADD `user_videos` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `user_subscribe_admin_mail` tinyint(1) NOT NULL DEFAULT '1' AFTER `user_email_verified`;

CREATE TABLE IF NOT EXISTS `admin_log` (
  `admin_log_id` int(11) NOT NULL auto_increment,
  `admin_log_user_id` int(11) NOT NULL,
  `admin_log_script` varchar(255) NOT NULL,
  `admin_log_time` int(11) NOT NULL,
  `admin_log_action` varchar(255) NOT NULL,
  `admin_log_extra` varchar(255) NOT NULL,
  `admin_log_ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`admin_log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `config` (`config_name`, `config_value`) VALUES ('youtube_player', 'youtube');

CREATE TABLE IF NOT EXISTS `video_responses` (
  `video_response_id` int(11) NOT NULL auto_increment,
  `video_response_video_id` int(11) NOT NULL,
  `video_response_to_video_id` int(11) NOT NULL,
  `video_response_active` int(1) NOT NULL default '0',
  `video_response_add_time` int(11) NOT NULL,
  PRIMARY KEY  (`video_response_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `email_templates` (`email_id` ,`email_subject` ,`email_body` ,`comment`) VALUES ('video_response_notify', '[SITE_NAME] - Video response to "[VIDEO_TITLE]"', '<p><a href="[SITE_URL]/[USERNAME]">[USERNAME]</a> has posted a video in response to <a href="[VIDEO_URL]">[VIDEO_TITLE]</a></p> <p>Response Video: <a href="[RESPONSE_VIDEO_URL]">[RESPONSE_VIDEO_TITLE]</a></p><p>This video requires your approval. You can approve or reject it by visiting the following link.</p><p><a href="[VERIFY_LINK]">[VERIFY_LINK]</a></p><p>Thanks</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'video response notify');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES ('unsubscribe_admin_mail', 'admin mail footer', '<br />\r\n<a href="[UNSUBSCRIBE_URL]" target="_blank">Unsubscribe</a>', 'admin mail footer');

DROP TABLE IF EXISTS `playlists`;

CREATE TABLE IF NOT EXISTS `playlists_videos` (
`playlists_videos_playlist_id` int( 11 ) NOT NULL DEFAULT 0,
`playlists_videos_video_id` bigint( 20 ) default NULL
);

CREATE TABLE IF NOT EXISTS `playlists` (
`playlist_id` int(11) NOT NULL auto_increment,
`playlist_user_id` int(11) NOT NULL,
`playlist_name` varchar(50) NOT NULL,
`playlist_add_date` varchar(255) NOT NULL,
PRIMARY KEY (`playlist_id`)
);

INSERT INTO `config` (`config_name`, `config_value`) VALUES ('vshare_player', 'JW Player');
INSERT INTO `sconfig` (`soption` ,`svalue`) VALUES ('family_filter', '1');
ALTER TABLE `process_queue` ADD `adult` TINYINT( 1 ) NOT NULL DEFAULT '0';
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_age_min_enforce', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_age_min', '18');
ALTER TABLE `users` CHANGE `user_account_status` `user_account_status` ENUM( 'Active', 'Inactive', 'Suspended' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Active';

CREATE TABLE IF NOT EXISTS `sitemap` (
  `sitemap_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `sitemap_name` VARCHAR( 255 ) NOT NULL ,
  `sitemap_create_date` INT( 11 ) NOT NULL ,
  `sitemap_url_count` INT( 11 ) NOT NULL default '0',
  `sitemap_size` INT( 11 ) NOT NULL ,
  `sitemap_last_video_id` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `config` (`config_name` ,`config_value`) VALUES ('user_daily_mail_limit', '50');

CREATE TABLE `mail_logs` (
  `mail_log_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `mail_log_user_id` INT( 11 ) NOT NULL ,
  `mail_log_time` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8;

UPDATE `sconfig` SET `svalue` = '640' WHERE `soption` = 'player_width';
UPDATE `sconfig` SET `svalue` = '390' WHERE `soption` = 'player_height';
UPDATE `sconfig` SET `svalue` = '2.8.1' WHERE `soption` = 'version';
