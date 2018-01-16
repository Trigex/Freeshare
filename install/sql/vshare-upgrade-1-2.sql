ALTER TABLE `video` ADD `active` INT( 1 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `video` ADD `approve` INT( 1 ) DEFAULT '0' NOT NULL ;
INSERT INTO `sconfig` ( `soption` , `svalue` )	VALUES ( 'approve', '0');
INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'debug', '0');
INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'notify_signup', '1');
INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'notify_upload', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES ('guest_limit', '200000');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES ('watermark_url', 'http://www.buyscripts.in');

DROP TABLE IF EXISTS `adv`;

CREATE TABLE `adv` (
  `adv_id` bigint(20) NOT NULL auto_increment,
  `adv_name` varchar(255) NOT NULL default '',
  `adv_text` text NOT NULL,
  `adv_status` enum('Active','Inactive') NOT NULL default 'Active',
  PRIMARY KEY  (`adv_id`)
) TYPE=MyISAM;

INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`)  VALUES (1, 'banner_top', '<TABLE BGCOLOR=#000000 WIDTH=700 height=100 ALIGN=center border=0>\r\n<TR>\r\n<TD align=center >\r\n<font color=#ffffff>PUT ADVT HERE</font>\r\n</TD>\r\n</TR>\r\n</TABLE>', 'Active');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`)  VALUES (2, 'banner_bottom', '<TABLE BGCOLOR=#000000 WIDTH=700 height=100 ALIGN=center border=0>\r\n<TR>\r\n<TD align=center >\r\n<font color=#ffffff>PUT ADVT HERE</font>\r\n</TD>\r\n</TR>\r\n</TABLE>', 'Inactive');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`)  VALUES (3, 'home_right_box', '<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=100% BGCOLOR=#000000>\r\n<TR>\r\n<TD >\r\n<FONT color=white>PUT ADVT HERE</font>\r\n</TD>\r\n</TR>\r\n</TABLE>', 'Inactive');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`)  VALUES (4, 'video_right_single', '<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=100% BGCOLOR=#000000>\r\n<TR>\r\n<TD >\r\n<FONT color=white>PUT ADVT HERE</font>\r\n</TD>\r\n</TR>\r\n</TABLE>', 'Inactive');


DROP TABLE IF EXISTS `emailinfo`;

CREATE TABLE `emailinfo` (
  `email_id` varchar(50) NOT NULL default '',
  `email_subject` varchar(255) NOT NULL default '',
  `email_path` varchar(255) NOT NULL default '',
  `comment` varchar(255) default NULL,
  PRIMARY KEY  (`email_id`)
) TYPE=MyISAM;

INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('verify_email', 'About email verification', 'emails/verify_email.tpl', 'Email Verification');
INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('invite_email', 'Friendship invitation from  $sender_name', 'emails/invite_email.tpl', 'To invite a friend');
INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('invite_group_email', '$sender_name has invited you to join YouTube group $gname', 'emails/invite_group_email.tpl', 'Send invitation to join a group');
INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('recover_password', 'Your site login password', 'emails/recover_password.tpl', 'Recovering user login password');
INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('parents_varification_email', 'About email varification', 'emails/parents_varification_email.tpl', 'mail to parents after registration');
INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('friends_email', 'Your friend has registered in $site_name', 'emails/friends_email.tpl', 'mail to friends after registration');
INSERT INTO `emailinfo` (`email_id`, `email_subject`, `email_path`, `comment`) VALUES ('registration_greeting_mail', 'Tank you form registration here.', 'emails/registration_greeting_mail.tpl', 'registration greeting mail');

update video set active=1;
