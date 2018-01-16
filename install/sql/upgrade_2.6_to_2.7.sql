-- http://www.phpwact.org/php/i18n/utf-8/mysql
-- http://www.mysqlperformanceblog.com/2009/03/17/converting-character-sets/
-- http://dev.mysql.com/doc/refman/5.0/en/charset-column.html

ALTER TABLE adv CONVERT TO CHARACTER SET utf8;
ALTER TABLE buddy_list CONVERT TO CHARACTER SET utf8;
ALTER TABLE channel CONVERT TO CHARACTER SET utf8;
ALTER TABLE comments CONVERT TO CHARACTER SET utf8;
ALTER TABLE config CONVERT TO CHARACTER SET utf8;
ALTER TABLE disallow CONVERT TO CHARACTER SET utf8;
ALTER TABLE emailinfo CONVERT TO CHARACTER SET utf8;
ALTER TABLE favourite CONVERT TO CHARACTER SET utf8;
ALTER TABLE feature_req CONVERT TO CHARACTER SET utf8;
ALTER TABLE friends CONVERT TO CHARACTER SET utf8;
ALTER TABLE group_mem CONVERT TO CHARACTER SET utf8;
ALTER TABLE group_own CONVERT TO CHARACTER SET utf8;
ALTER TABLE group_tps CONVERT TO CHARACTER SET utf8;
ALTER TABLE group_tps_post CONVERT TO CHARACTER SET utf8;
ALTER TABLE group_vdo CONVERT TO CHARACTER SET utf8;
ALTER TABLE guest_info CONVERT TO CHARACTER SET utf8;
ALTER TABLE inappro_req CONVERT TO CHARACTER SET utf8;
ALTER TABLE last_5users CONVERT TO CHARACTER SET utf8;
ALTER TABLE package CONVERT TO CHARACTER SET utf8;
ALTER TABLE pages CONVERT TO CHARACTER SET utf8;
ALTER TABLE playlist CONVERT TO CHARACTER SET utf8;
ALTER TABLE pm CONVERT TO CHARACTER SET utf8;
ALTER TABLE poll_question CONVERT TO CHARACTER SET utf8;
ALTER TABLE process_queue CONVERT TO CHARACTER SET utf8;
ALTER TABLE profile_comments CONVERT TO CHARACTER SET utf8;
ALTER TABLE relation CONVERT TO CHARACTER SET utf8;
ALTER TABLE sconfig CONVERT TO CHARACTER SET utf8;
ALTER TABLE servers CONVERT TO CHARACTER SET utf8;
ALTER TABLE signup CONVERT TO CHARACTER SET utf8;
ALTER TABLE subscriber CONVERT TO CHARACTER SET utf8;
ALTER TABLE tags CONVERT TO CHARACTER SET utf8;
ALTER TABLE tag_video CONVERT TO CHARACTER SET utf8;
ALTER TABLE uservote CONVERT TO CHARACTER SET utf8;
ALTER TABLE verify_code CONVERT TO CHARACTER SET utf8;
ALTER TABLE video CONVERT TO CHARACTER SET utf8;
ALTER TABLE vote_result CONVERT TO CHARACTER SET utf8;
ALTER TABLE words CONVERT TO CHARACTER SET utf8;
ALTER TABLE `uservote` DROP `voted_date` ;
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('num_max_channels','3');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('captcha_type','recaptcha');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('allow_html','1');
DELETE FROM `sconfig` WHERE `soption`='flashplayer';
DELETE FROM `sconfig` WHERE `soption`='activexinstall';
DELETE FROM `sconfig` WHERE `soption`='authorizelogin';
DELETE FROM `sconfig` WHERE `soption`='authorizekey';
DELETE FROM `sconfig` WHERE `soption`='pollinganel';
DELETE FROM `sconfig` WHERE `soption`='authorizelogin';
DELETE FROM `sconfig` WHERE `soption`='authorizekey';
DELETE FROM `sconfig` WHERE `soption`='emailsender';
DELETE FROM `sconfig` WHERE `soption`='max_video_size';
DELETE FROM `sconfig` WHERE `soption`='max_display_size';
INSERT INTO `sconfig` (`soption` ,`svalue`) VALUES ('meta_keywords', '');
INSERT INTO `sconfig` (`soption` ,`svalue`) VALUES ('meta_description', '');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES ('cache_enable', '0');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('num_channel_video', '4');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('guest_upload', '0');
INSERT INTO `config` ( `config_name` , `config_value` ) VALUES ('guest_upload_user', '');
ALTER TABLE `channel` ADD `seo_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`;
ALTER TABLE `signup` RENAME TO `users`;
ALTER TABLE `channel` RENAME TO `channels`;
ALTER TABLE `video` RENAME TO `videos`;
ALTER TABLE `group_own` RENAME TO `groups`;
ALTER TABLE `emailinfo` RENAME TO `email_templates`;
ALTER TABLE `groups` CHANGE `gcrtime` `group_create_time` INT( 11 ) NOT NULL;
INSERT INTO `adv` SET `adv_name`='wide_skyscraper', `adv_text`='<img src="http://video.bizhat.com/test/wide_tower.png" alt="" />',`adv_status`= 'Inactive';
INSERT INTO `adv` SET `adv_name`='player_top', `adv_text`='<div align="center"><img src="http://adserver.bizhat.com/banners/vshare_1.gif" width="468" height="60" alt="advertisement" /></div>', `adv_status`='Inactive';
INSERT INTO `adv` SET `adv_name`='player_bottom', `adv_text`='<div align="center"><img src="http://adserver.bizhat.com/banners/vshare_1.gif" width="468" height="60" alt="advertisement" /></div>', `adv_status`='Inactive';
ALTER TABLE package RENAME TO packages;
ALTER TABLE `packages` DROP `bandwidth`;
ALTER TABLE `packages` CHANGE `pack_id` `package_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `packages` CHANGE `pack_name` `package_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `packages` CHANGE `pack_desc` `package_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `packages` CHANGE `space` `package_space` BIGINT(20) NOT NULL DEFAULT '0';
ALTER TABLE `packages` CHANGE `price` `package_price` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `packages` CHANGE `video_limit` `package_videos` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `packages` CHANGE `period` `package_period` ENUM('Day', 'Month', 'Year') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Month';
ALTER TABLE `packages` CHANGE `status` `package_status` ENUM('Active', 'Inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Active';
ALTER TABLE `packages` CHANGE `is_trial` `package_trial` CHAR(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';
ALTER TABLE `packages` CHANGE `trial_period` `package_trial_period` INT(11) NULL DEFAULT NULL;


ALTER TABLE `users` CHANGE `UID` `user_id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users` CHANGE `email` `user_email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `username` `user_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `pwd` `user_password` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `fname` `user_first_name` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `lname` `user_last_name` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `bdate` `user_birth_date` DATE NOT NULL DEFAULT '0000-00-00';
ALTER TABLE `users` CHANGE `gender` `user_gender` VARCHAR(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `relation` `user_relation` VARCHAR(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `aboutme` `user_about_me` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `website` `user_website` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `town` `user_town` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `city` `user_city` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `zip` `user_zip` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `country` `user_country` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `occupation` `user_occupation` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `company` `user_company` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `school` `user_school` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `interest_hobby` `user_interest_hobby` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `fav_movie_show` `user_fav_movie_show` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `fav_music` `user_fav_music` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `fav_book` `user_fav_book` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `friends_type` `user_friends_type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'All|Family|Friends';
ALTER TABLE `users` CHANGE `video_viewed` `user_video_viewed` INT( 10 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` CHANGE `profile_viewed` `user_profile_viewed` INT( 10 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` CHANGE `watched_video` `user_watched_video` INT( 10 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` CHANGE `addtime` `user_join_time` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `logintime` `user_last_login_time` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `emailverified` `user_email_verified` CHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';
ALTER TABLE `users` CHANGE `account_status` `user_account_status` ENUM( 'Active', 'Inactive' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Active';
ALTER TABLE `users` CHANGE `vote` `user_vote` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `ratedby` `user_rated_by` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0';
ALTER TABLE `users` CHANGE `rate` `user_rate` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0';
ALTER TABLE `users` CHANGE `parents_name` `user_parents_name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `parents_email` `user_parents_email` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `friends_name` `user_friends_name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `friends_email` `user_friends_email` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `users` CHANGE `adult` `user_adult` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `user_photo` INT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `users` ADD `user_background` INT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `VID` `video_id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `videos` CHANGE `UID` `video_user_id` BIGINT( 20 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `seo_name` `video_seo_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `title` `video_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `description` `video_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `keyword` `video_keywords` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `channel` `video_channels` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0|';
ALTER TABLE `videos` CHANGE `vdoname` `video_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `flvdoname` `video_flv_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `videos` CHANGE `duration` `video_duration` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `video_length` `video_length` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `videos` CHANGE `space` `video_space` FLOAT UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `type` `video_type` VARCHAR( 7 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `vtype` `video_vtype` INT( 2 ) NOT NULL;
ALTER TABLE `videos` CHANGE `addtime` `video_add_time` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `videos` CHANGE `adddate` `video_add_date` DATE NOT NULL DEFAULT '0000-00-00';
ALTER TABLE `videos` CHANGE `record_date` `video_record_date` DATE NOT NULL DEFAULT '0000-00-00';
ALTER TABLE `videos` CHANGE `location` `video_location` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `country` `video_country` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `viewnumber` `video_view_number` BIGINT( 10 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `com_num` `video_com_num` INT( 8 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `fav_num` `video_fav_num` INT( 8 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `featured` `video_featured` CHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';
ALTER TABLE `videos` CHANGE `ratedby` `video_rated_by` BIGINT( 10 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `rate` `video_rate` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `be_comment` `video_allow_comment` CHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes';
ALTER TABLE `videos` CHANGE `be_rated` `video_allow_rated` CHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes';
ALTER TABLE `videos` CHANGE `embed` `video_allow_embed` VARCHAR( 8 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'enabled';
ALTER TABLE `videos` CHANGE `embed_code` `video_embed_code` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `videos` CHANGE `voter_id` `video_voter_id` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `videos` CHANGE `active` `video_active` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `approve` `video_approve` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `adult` `video_adult` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` CHANGE `server_id` `video_server_id` INT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `videos` DROP `filehome`;
ALTER TABLE `videos` DROP `featuredesc`;
ALTER TABLE `videos` ADD `video_folder` VARCHAR( 255 ) NOT NULL AFTER `video_server_id`;

ALTER TABLE `pages` CHANGE `id` `page_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `pages` CHANGE `name` `page_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `pages` CHANGE `title` `page_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `pages` CHANGE `keywords` `page_keywords` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `pages` CHANGE `description` `page_description` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `pages` CHANGE `content` `page_content` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `pages` CHANGE `counter` `page_counter` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `pages` CHANGE `tpl` `page_tpl` INT( 1 ) NOT NULL DEFAULT '1';
ALTER TABLE `pages` CHANGE `members_only` `page_members_only` INT( 1 ) NOT NULL DEFAULT '0';

ALTER TABLE `channels` CHANGE `CHID` `channel_id` BIGINT(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `channels` CHANGE `name` `channel_name` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `channels` CHANGE `seo_name` `channel_seo_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `channels` CHANGE `descrip` `channel_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `channels` CHANGE `sortorder` `channel_sort_order` INT( 2 ) NOT NULL DEFAULT '1';

ALTER TABLE `groups` CHANGE `GID` `group_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `groups` CHANGE `gname` `group_name` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `keyword` `group_keyword` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `gdescn` `group_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `gurl` `group_url` VARCHAR(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `channel` `group_channels` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `type` `group_type` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `gupload` `group_upload` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `gposting` `group_posting` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `gimage` `group_image` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `groups` CHANGE `gimage_vdo` `group_image_video` INT(11) NULL DEFAULT NULL;
ALTER TABLE `groups` CHANGE `featured` `group_featured` CHAR(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';
ALTER TABLE `groups` CHANGE `OID` `group_owner_id` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `comments` CHANGE `COMID` `comment_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `comments` CHANGE `VID` `comment_video_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `comments` CHANGE `UID` `comment_user_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `comments` CHANGE `commen` `comment_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `comments` CHANGE `addtime` `comment_add_time` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `profile_comments` CHANGE `id` `profile_comment_id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `profile_comments` CHANGE `uid` `profile_comment_user_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `profile_comments` CHANGE `posted_by` `profile_comment_posted_by` INT( 11 ) NOT NULL;
ALTER TABLE `profile_comments` CHANGE `comment` `profile_comment_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `profile_comments` CHANGE `ip` `profile_comment_ip` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `profile_comments` CHANGE `date` `profile_comment_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';

INSERT INTO `disallow` SET `disallow_username`='administrator';
INSERT INTO `disallow` SET `disallow_username`='admin';
INSERT INTO `disallow` SET `disallow_username`='webmaster';
INSERT INTO `disallow` SET `disallow_username`='style';
INSERT INTO `disallow` SET `disallow_username`='signup';
INSERT INTO `disallow` SET `disallow_username`='login';

RENAME TABLE `group_vdo`  TO `group_videos`;
ALTER TABLE `group_videos` CHANGE `GID` `group_video_group_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `group_videos` CHANGE `VID` `group_video_video_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `group_videos` CHANGE `MID` `group_video_member_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `group_videos` CHANGE `approved` `group_video_approved` CHAR(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes';

ALTER TABLE `friends` CHANGE `id` `friend_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `friends` CHANGE `UID` `friend_user_id` INT(11 ) NOT NULL DEFAULT '0';
ALTER TABLE `friends` CHANGE `FID` `friend_friend_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `friends` CHANGE `friends_name` `friend_name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `friends` CHANGE `friends_type` `friend_type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'All';
ALTER TABLE `friends` CHANGE `invite_date` `friend_invite_date` DATE NOT NULL DEFAULT '0000-00-00';
ALTER TABLE `friends` CHANGE `friends_status` `friend_status` ENUM( 'Pending', 'Confirmed', 'DENIED' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Pending';
ALTER TABLE `favourite` CHANGE `UID` `favourite_user_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `favourite` CHANGE `VID` `favourite_video_id` INT( 11 ) NOT NULL DEFAULT '0';

RENAME TABLE `group_mem` TO `group_members`;
ALTER TABLE `group_members` CHANGE `GID` `group_member_group_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_members` CHANGE `MID` `group_member_user_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_members` CHANGE `member_since` `group_member_since` DATE NOT NULL DEFAULT '0000-00-00';
ALTER TABLE `group_members` CHANGE `approved` `group_member_approved` CHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes';

RENAME TABLE `group_tps_post`  TO `group_topic_posts`;
ALTER TABLE `group_topic_posts` CHANGE `PID` `group_topic_post_id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `group_topic_posts` CHANGE `TID` `group_topic_post_topic_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_topic_posts` CHANGE `UID` `group_topic_post_user_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_topic_posts` CHANGE `VID` `group_topic_post_video_id` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `group_topic_posts` CHANGE `post` `group_topic_post_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `group_topic_posts` CHANGE `date` `group_topic_post_date` INT( 11 ) NOT NULL;

RENAME TABLE `group_tps` TO `group_topics` ;
ALTER TABLE `group_topics` CHANGE `TID` `group_topic_id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `group_topics` CHANGE `GID` `group_topic_group_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_topics` CHANGE `UID` `group_topic_user_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_topics` CHANGE `addtime` `group_topic_add_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `group_topics` CHANGE `title` `group_topic_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `group_topics` CHANGE `VID` `group_topic_video_id` BIGINT( 20 ) NOT NULL DEFAULT '0';
ALTER TABLE `group_topics` CHANGE `approved` `group_topic_approved` CHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes';

RENAME TABLE `feature_req` TO `feature_requests`;
ALTER TABLE `feature_requests` CHANGE `VID` `feature_request_video_id` BIGINT( 20 ) NOT NULL DEFAULT '0';
ALTER TABLE `feature_requests` CHANGE `req` `feature_request_count` BIGINT( 20 ) NOT NULL DEFAULT '0';
ALTER TABLE `feature_requests` CHANGE `date` `feature_request_date` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

RENAME TABLE `vote_result`  TO `poll_results`;
ALTER TABLE `poll_results` CHANGE `vote_id` `poll_result_vote_id` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `poll_results` CHANGE `voter_id` `poll_result_voter_id` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `poll_results` CHANGE `answer` `poll_result_answer` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `poll_results` CHANGE `client_ip` `poll_result_client_ip` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `poll_results` CHANGE `voted_date` `poll_result_date` DATE NOT NULL DEFAULT '0000-00-00';

RENAME TABLE `pm`  TO `mails` ;
ALTER TABLE `mails` CHANGE `pm_id` `mail_id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `mails` CHANGE `subject` `mail_subject` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `mails` CHANGE `body` `mail_body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `mails` CHANGE `sender` `mail_sender` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `mails` CHANGE `receiver` `mail_receiver` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `mails` CHANGE `date` `mail_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `mails` CHANGE `seen` `mail_read` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `mails` CHANGE `inbox_track` `mail_inbox_track` INT( 11 ) NOT NULL DEFAULT '2';
ALTER TABLE `mails` CHANGE `outbox_track` `mail_outbox_track` INT( 11 ) NOT NULL DEFAULT '2';

RENAME TABLE `playlist`  TO `playlists`;
ALTER TABLE `playlists` CHANGE `UID` `playlist_user_id` BIGINT( 20 ) NULL DEFAULT NULL;
ALTER TABLE `playlists` CHANGE `VID` `playlist_video_id` BIGINT( 20 ) NULL DEFAULT NULL;

CREATE TABLE `view_log` (
`view_log_id` INT( 1 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`view_log_video_id` INT( 11 ) NOT NULL ,
`view_log_ip` VARCHAR( 255 ) NOT NULL ,
`view_log_time` INT( 11 ) NOT NULL
);

RENAME TABLE `inappro_req`  TO `inappropriate_requests`;
ALTER TABLE `inappropriate_requests` CHANGE `VID` `inappropriate_request_video_id` BIGINT( 20 ) NOT NULL DEFAULT '0';
ALTER TABLE `inappropriate_requests` CHANGE `req` `inappropriate_request_count` BIGINT( 20 ) NOT NULL DEFAULT '0';
ALTER TABLE `inappropriate_requests` CHANGE `date` `inappropriate_request_date` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `servers` ADD `server_type` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `space_used`;
ALTER TABLE `servers` ADD `server_secdownload_secret` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

CREATE TABLE IF NOT EXISTS `import_track` (
  `import_track_id` int(11) NOT NULL auto_increment,
  `import_track_unique_id` varchar(255) character set utf8 NOT NULL,
  `import_track_site` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`import_track_id`),
  UNIQUE KEY `import_track_unique_id` (`import_track_unique_id`)
) DEFAULT CHARSET=utf8;

ALTER TABLE `videos` ADD `video_thumb_server_id` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `video_server_id` ;

CREATE TABLE IF NOT EXISTS `import_auto` (
  `import_auto_id` int(11) unsigned NOT NULL auto_increment,
  `import_auto_keywords` text NOT NULL,
  `import_auto_download` int(1) NOT NULL default '0',
  PRIMARY KEY  (`import_auto_id`)
) DEFAULT CHARSET=utf8;

ALTER TABLE `users` ADD `user_salt` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `user_password`;
ALTER TABLE `users` ADD `user_ip` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `user_last_login_time`;
ALTER TABLE `users` ADD `user_style` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

CREATE TABLE IF NOT EXISTS `import_auto` (
  `import_auto_id` int(11) unsigned NOT NULL auto_increment,
  `import_auto_keywords` varchar(255) character set utf8 NOT NULL,
  `import_auto_download` int(1) NOT NULL default '0',
  `import_auto_channel` int(4) NOT NULL,
  `import_auto_user` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`import_auto_id`)
) DEFAULT CHARSET=utf8;

UPDATE `email_templates` SET `email_body` = '<p>Hi, </p><p>You got a new private message from user <a href="[SITE_URL]/[USERNAME]">[USERNAME]</a></p><p>------ </p><p>[MESSAGE]</p><p>------ </p><p>Thanking you, </p><p><a href="[SITE_URL]">[SITE_NAME]</a> </p>' WHERE `email_templates`.`email_id` = 'pm_notify' LIMIT 1 ;

DROP TABLE `last_5users`;

CREATE TABLE `user_logins` (
`user_login_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`user_login_user_id` INT( 11 ) NOT NULL ,
`user_login_time` INT( 11 ) NOT NULL ,
`user_login_ip` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM;

ALTER TABLE `videos` ADD FULLTEXT (`video_title`);
ALTER TABLE `videos` ADD FULLTEXT (`video_description`);
ALTER TABLE `videos` ADD FULLTEXT (`video_keywords`);

UPDATE `sconfig` SET `svalue` = '600' WHERE `soption` = 'player_width';
UPDATE `sconfig` SET `svalue` = '500' WHERE `soption` = 'player_height';
UPDATE `sconfig` SET `svalue` = '20' WHERE `soption` = 'num_watch_videos';

ALTER TABLE `process_queue` CHANGE `user_ip` `process_queue_upload_ip` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

UPDATE `sconfig` SET `svalue` = '2.7' WHERE `soption` = 'version';
