DROP TABLE IF EXISTS `playlists`;
DROP TABLE IF EXISTS `video_playlists`;

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

CREATE TABLE IF NOT EXISTS `video_responses` (
  `video_response_id` int(11) NOT NULL auto_increment,
  `video_response_video_id` int(11) NOT NULL,
  `video_response_to_video_id` int(11) NOT NULL,
  `video_response_active` int(1) NOT NULL default '0',
  `video_response_add_time` int(11) NOT NULL,
  PRIMARY KEY  (`video_response_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

ALTER TABLE `process_queue` CHANGE `adult` `adult` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `process_queue` ADD `import_track_id` INT( 11 ) NOT NULL AFTER `process_queue_upload_ip`;
ALTER TABLE `import_track` ADD `import_track_video_id` INT( 11 ) NOT NULL AFTER `import_track_unique_id`;
ALTER TABLE `users` ADD `user_videos` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `user_subscribe_admin_mail` tinyint(1) NOT NULL DEFAULT '1' AFTER `user_email_verified`;

INSERT INTO `email_templates` (`email_id` ,`email_subject` ,`email_body` ,`comment`) VALUES ('video_response_notify', '[SITE_NAME] - Video response to "[VIDEO_TITLE]"', '<p><a href="[SITE_URL]/[USERNAME]">[USERNAME]</a> has posted a video in response to <a href="[VIDEO_URL]">[VIDEO_TITLE]</a></p> <p>Response Video: <a href="[RESPONSE_VIDEO_URL]">[RESPONSE_VIDEO_TITLE]</a></p><p>This video requires your approval. You can approve or reject it by visiting the following link.</p><p><a href="[VERIFY_LINK]">[VERIFY_LINK]</a></p><p>Thanks</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'video response notify');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES ('unsubscribe_admin_mail', 'admin mail footer', '<br />\r\n<a href="[UNSUBSCRIBE_URL]" target="_blank">Unsubscribe</a>', 'admin mail footer');
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('vshare_player', 'JW Player');
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('youtube_player', 'youtube');

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
