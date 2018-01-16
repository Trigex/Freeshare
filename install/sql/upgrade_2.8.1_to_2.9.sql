INSERT INTO `config` (`config_name` ,`config_value`) VALUES ('moderate_video_links', '1');
INSERT INTO `config` (`config_name` ,`config_value`) VALUES ('hotlink_protection', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('video_comment_notify', '0');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES ('video_comment_notify', '[SITE_NAME] - Comment posted on your video', '<p>Hello <a href="[SITE_URL]/[VIDEO_OWNER_NAME]">[VIDEO_OWNER_NAME]</a>,</p><p><a href="[SITE_URL]/[COMMENT_USER_NAME]">[COMMENT_USER_NAME]</a> has commented on your video.</p><p>Check it by clicking the following link,</p><p><a href="[VIDEO_URL]">[VIDEO_TITLE]</a></p><p>Thanks,</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team.</p>', 'video comment notification');
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('dailymotion_api_key', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('dailymotion_api_secret', '');
DELETE FROM `config` WHERE `config_name`='video_duration_cmd';
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('tool_video_thumb', 'ffmpeg');
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('video_output_format', 'mp4');

UPDATE `sconfig` SET `svalue` = '2.9' WHERE `soption` = 'version';
INSERT INTO `config` (`config_name`, `config_value`) VALUES ('upload_progress_bar', 'none');