-- Table structure for table `adv`

CREATE TABLE IF NOT EXISTS `adv` (
  `adv_id` int(11) NOT NULL auto_increment,
  `adv_name` varchar(255) NOT NULL default '',
  `adv_text` text NOT NULL,
  `adv_status` enum('Active','Inactive') NOT NULL default 'Active',
  PRIMARY KEY  (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- Dumping data for table `adv`

INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(1, 'banner_top', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-horizontal.png" width="728px" height="90px"></a></p>', 'Active');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(2, 'banner_bottom', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-horizontal.png" width="728px" height="90px"></a></p>', 'Active');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(3, 'home_right_box', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-vertical.png" width="250px" height="250px"></a></p>', 'Active');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(4, 'video_right_single', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-vertical.png" width="300px" height="250px"></a></p>', 'Active');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(5, 'wide_skyscraper', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-vertical.png" width="160px" height="600px"></a></p>', 'Active');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(6, 'player_top', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-horizontal.png" width="468px" height="60px"></a></p>', 'Inactive');
INSERT INTO `adv` (`adv_id`, `adv_name`, `adv_text`, `adv_status`) VALUES(7, 'player_bottom', '<p class=text-center><a href="http://buyscripts.in/docs/vshare/3.0/advertisements" target="_blank"><img src="/themes/default/images/placeholder-horizontal.png" width="468px" height="60px"></a></p>', 'Inactive');

-- Table structure for table `buddy_list`

CREATE TABLE IF NOT EXISTS `buddy_list` (
  `user_name` varchar(80) default NULL,
  `buddy_name` varchar(80) default NULL,
  UNIQUE KEY `user_name` (`user_name`,`buddy_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `buddy_list`


-- Table structure for table `channels`

CREATE TABLE IF NOT EXISTS `channels` (
  `channel_id` int(11) NOT NULL auto_increment,
  `channel_name` varchar(120) NOT NULL,
  `channel_seo_name` varchar(255) NOT NULL,
  `channel_description` text NOT NULL,
  `channel_sort_order` int(2) NOT NULL default '1',
  PRIMARY KEY  (`channel_id`),
  UNIQUE KEY `name` (`channel_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- Dumping data for table `channels`

INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(1, 'Sports', 'sports', 'Games, Stadiums, Tailgating...', 1);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(2, 'Humor', 'humor', 'Funny, Bloopers, Pranks...', 2);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(3, 'Arts & Animation', 'arts-animation', 'Artistic, Computer Graphics, Anime...', 3);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(4, 'Autos & Vehicles', 'autos-vehicles', 'Cars, Boats, Airplanes...', 4);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(5, 'Hobbies & Interests', 'hobbies-interests', 'Haunted Dolls, Cooking, RC Planes...', 5);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(6, 'Education & Instructional', 'education-instructional', 'Tutorials, Software Demos, Cooking Techniques...', 6);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(7, 'Trailers', 'trailers', 'Movies, Games', 7);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(8, 'Fights', 'fights', 'Brawls, Scuffles, Cat Fights', 8);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(9, 'Video Blogs', 'video-blogs', 'Upload your video blog', 9);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(10, 'News', 'news', 'Anything Newsy', 10);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(11, 'Music', 'music', 'Hot videos', 11);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(12, 'College', 'college', 'Anything College', 12);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(13, 'Stupid Video', 'stupid-video', 'Stupid things people do on video', 13);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(14, 'Funny', 'funny', 'Just plain funny videos.', 14);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(15, 'Personal Videos', 'personal-videos', 'anything goes.', 16);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(16, 'Breaking News', 'breaking-news', 'breaking news events world wide', 16);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(17, 'Politics', 'politics', 'Politics, Political, Corruption', 17);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(18, 'Military & War', 'military-war', 'Military, Troops, Worldwide', 18);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(19, 'TV Commercials', 'tv-commercials', 'TV, Banned Commercials', 19);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(20, 'Cool', 'cool', 'Cool, Wow', 20);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(21, 'Weird Videos', 'weird-videos', 'Weird', 21);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(22, 'Travel & Places', 'travel-places', 'tourist important places', 22);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(23, 'Sexy', 'sexy', 'Beach Babes, Hot Dancers', 23);
INSERT INTO `channels` (`channel_id`, `channel_name`, `channel_seo_name`, `channel_description`, `channel_sort_order`) VALUES(24, 'Pets & Animals', 'pets-animals', 'Animal Lovers Channel', 24);

-- Table structure for table `comments`

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `comment_video_id` int(11) NOT NULL default '0',
  `comment_user_id` int(11) NOT NULL default '0',
  `comment_text` text NOT NULL,
  `comment_add_time` varchar(20) NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `comment_video_id` (`comment_video_id`,`comment_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `comments`


-- Table structure for table `config`

CREATE TABLE IF NOT EXISTS `config` (
  `config_name` varchar(255) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  PRIMARY KEY  (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `config`

INSERT INTO `config` (`config_name`, `config_value`) VALUES('cron', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('admin_listing_per_page', '20');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('php_path', '/usr/bin/php');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('home_num_tags', '20');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('process_upload', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('process_notify_user', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('num_last_users_online', '5');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('recommend_all', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_dob', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_enable', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('tool_video_thumb', 'ffmpeg');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('editor_wysiwyg_admin', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('editor_wysiwyg_email', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('mail_abuse_report', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_auto_friend', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('flv_metadata', 'flvtool');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('video_flv_delete', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('video_source_delete', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('num_max_channels', '3');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('allow_html', '1');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('num_channel_video', '4');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('guest_upload', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('guest_upload_user', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('youtube_player', 'youtube');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('vshare_player', 'videojs');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_age_min_enforce', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('signup_age_min', '18');
INSERT INTO `config` (`config_name` ,`config_value`) VALUES('user_daily_mail_limit', '50');
INSERT INTO `config` (`config_name` ,`config_value`) VALUES('video_comment_notify', '0');
INSERT INTO `config` (`config_name` ,`config_value`) VALUES('moderate_video_links', '1');
INSERT INTO `config` (`config_name` ,`config_value`) VALUES('hotlink_protection', '0');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('dailymotion_api_key', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('dailymotion_api_secret', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('upload_progress_bar', 'none');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('video_output_format', 'mp4');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('youtube_api_key', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('user_photo_width', '160');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('user_photo_height', '160');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('user_avatar_width', '40');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('user_avatar_height', '40');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('recaptcha_sitekey', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('recaptcha_secretkey', '');
INSERT INTO `config` (`config_name`, `config_value`) VALUES('spam_filter', '0');

-- Table structure for table `contact`

CREATE TABLE IF NOT EXISTS `contact` (
  `fname` varchar(50) NOT NULL default '',
  `lname` varchar(50) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `submit_date` varchar(15) NOT NULL default '',
  `user_ip` varchar(20) NOT NULL default '',
  `message` varchar(200) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `flag` varchar(20) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `contact`


-- Table structure for table `disallow`

CREATE TABLE IF NOT EXISTS `disallow` (
  `disallow_id` mediumint(8) unsigned NOT NULL auto_increment,
  `disallow_username` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`disallow_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- Dumping data for table `disallow`

INSERT INTO `disallow` (`disallow_id`, `disallow_username`) VALUES(1, 'admin');
INSERT INTO `disallow` (`disallow_id`, `disallow_username`) VALUES(2, 'administrator');
INSERT INTO `disallow` (`disallow_id`, `disallow_username`) VALUES(3, 'webmaster');
INSERT INTO `disallow` (`disallow_id`, `disallow_username`) VALUES(4, 'login');
INSERT INTO `disallow` (`disallow_id`, `disallow_username`) VALUES(5, 'signup');
INSERT INTO `disallow` (`disallow_id`, `disallow_username`) VALUES(6, 'style');

-- Table structure for table `email_templates`

CREATE TABLE IF NOT EXISTS `email_templates` (
  `email_id` varchar(50) NOT NULL default '',
  `email_subject` varchar(255) NOT NULL default '',
  `email_body` text NOT NULL,
  `comment` varchar(255) default NULL,
  PRIMARY KEY  (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `email_templates`

INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('invite_friends', 'Invitation from  [SENDER_NAME]', '<p>Hello [RECEIVER_NAME],</p>  <p><a href="[SITE_URL]">[SITE_NAME]</a> is a new site for sharing and hosting personal videos. I have been using [SITE_NAME] to share videos with my friends and family. I would like to add you to the list of people I may share videos with.</p>  <p>Personal message from [SENDER_NAME]:</p>  <p>----------------------------</p> <p>[MESSAGE]</p> <p>----------------------------</p>  <p>To accept my friend request, click here:</p>  <p><a href="[VERIFY_URL]" target="_blank">[VERIFY_URL]</a></p>  <p>To visit [SITE_NAME], <a href="[SITE_URL]">click here</a>.</p>  <p>Thanks,</p> <p><a href="[SENDER_URL]">[SENDER_FNAME]</a></p>', 'Invite Friends');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('invite_group_email', '[SENDER_NAME] has invited you to join group [GROUP_NAME]', '<p>Hello [RECEIVER_NAME],</p><p>[SENDER_NAME] has invited you to join group [GROUP_NAME]&nbsp;</p> <p><a href="[GROUP_URL]">[GROUP_URL]</a></p> <p>------------------</p>  <p>[MESSAGE]</p>  <p>------------------</p>  <p>Click the link below to Join the group.</p><p><a href="[VERIFY_URL]">[VERIFY_URL]</a></p><p>To visit [SITE_NAME], <a href="[SITE_URL]">click here</a>.</p><p>Thanks,</p><p><a href="[SENDER_URL]">[SENDER_NAME]</a></p>', 'Group Invitation Mail');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('recover_password', '[SITE_NAME] - New password activation', '<p>Hello [RECEIVER_NAME],</p><p>You are receiving this notification because you have (or someone pretending<br />to be you has from IP: [USER_IP]) requested a new password be sent for your account on &quot;[SITE_NAME]&quot;.</p><p> If you did not request this notification then please ignore it,<br />if you keep receiving it please contact the site administrator.&nbsp;</p>  <p>To use the new password you need to activate it. To do this click the link<br />provided below.</p>  <p><a href="[VERIFY_URL]">[VERIFY_URL]</a></p><p>If successful you will be able to login using the following user name and password:&nbsp;</p><p>User Name: [RECEIVER_NAME]<br />Password: [PASSWORD]</p><p>You can of course change this password yourself via the profile page. If<br />you have any difficulties please contact the site administrator.</p>    <p>Thank you,</p>  <p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'User Password Reset');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('user_email_change', 'Action Required to Verify Membership for [SITE_NAME]', 'Dear [USERNAME],<p>Since you have recently changed your email, we require that you verify your new email address. You will only need to visit the url once to have your account updated.</p><p>To complete reverification, please visit this url:</p><p><a href="[VERIFY_URL]">[VERIFY_URL]</a></p><p>If you are still having problems verifying please contact us. </p><p>All the best,</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'User Email Change');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('friends_email', 'Your friend has registered in $site_name', '', 'mail to friends after registration');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('recommend_video', '[SENDER_NAME] - sent you a video!', '<p>Hello,</p>  <p>[MESSAGE]</p>  <p>Click the link below to View the video.</p>  <p><a href="[VIDEO_URL]">[VIDEO_URL]</a></p>  <p>To visit [SITE_NAME], <a href="[SITE_URL]">click here</a>.</p>  <p>Thanks,</p><p>[SENDER_NAME]</p>  <a href="[SENDER_URL]">[SENDER_URL]</a> ', 'Recommend Video');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('pm_notify', '[SITE_NAME] - You got a new private message', '<p>Hi, </p><p>You got a new private message from user [USERNAME]</p><p>------ </p><p>[MESSAGE]</p><p>------ </p><p>Thanking you, </p><p><a href="[SITE_URL]">[SITE_NAME]</a> </p>', 'PM Notify Email');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('admin_change_password', '[SITE_NAME] -  Admin Password Changed', '<p>Hello  [ADMIN_NAME] ,  </p>\r\n\r\n<p>Admin login details for your web site is changed.</p>\r\n\r\n<p>Click the link below to activate Admin password:</p>\r\n\r\n<p><a href="[ACTIVATE_URL]">[ACTIVATE_URL]</a>&nbsp;</p>\r\n\r\n<p>User Name: [ADMIN_NAME]  </p>\r\n\r\n<p>Password: [ADMIN_PASSWORD]  </p>\r\n\r\n<p>IP address of user that changed the admin password is: [REMOTE_ADDR]  </p>\r\n\r\n<p>Thank you,  </p>\r\n\r\n<p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'admin_change_password');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('admin_signup_notify', '[SITE_NAME] New Signup - [USERNAME]', '<p>New User Signup</p><p>User Name : [USERNAME]<br />Email     : [USER_EMAIL]<br />IP        : [REMOTE_ADDR] <br />	BROWSER   :  [HTTP_USER_AGENT]<br />PROFILE: <a href="[USER_URL]">[USER_URL]</a></p>', 'Admin Signup Notify');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('password_reset_admin', '[SITE_NAME] - Admin Password Change Request', '<p>Hello  [ADMIN_NAME], </p><p>You or someone requested for admin&nbsp;control&nbsp;panel password reset from IP address: [REMOTE_ADDR]</p><p>If you have not requested for password reset, just ignore the mail.</p><p>User Name: [ADMIN_NAME]<br />New Password: [PASSWORD]</p><p>Before using the&nbsp;new&nbsp;password,&nbsp;you&nbsp;need&nbsp;to&nbsp;activate&nbsp;it&nbsp;by&nbsp;clicking&nbsp;the&nbsp;link&nbsp;below. </p><p><a href="[VERIFY_URL]" target="_blank">[VERIFY_URL]</a> </p><p>Thank you,</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'Reset Admin Control Panel Password');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('upload_notify_user', 'Your Video [VIDEO_TITLE] Uploaded to [SITE_NAME]', 'Thank you for video uploaded.  <p>USER ID: [USER_ID]</p><p>USER IP: [USER_IP]</p><p>USERNAME: [USERNAME]</p><p>TITLE: [VIDEO_TITLE]</p><p>DESCRIPTION: [DESCRIPTION]</p><p>KEYWORDS: [KEYWORDS]</p><p>CHANNEL: [CHANNELS]</p><p>TYPE: [TYPE]</p><p>VIDEO URL: [VIDEO_URL]</p>', 'Email send to user after video processed.');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('resend_activation', '[SITE_NAME] - Activation Link', '<p>Dear [USERNAME],   </p><p>Click following link to activate your [SITE_NAME] account.  </p><p><a href="[VERIFY_URL]">[VERIFY_URL]</a>   </p><p>Thanking you,</p><p><a href="[SITE_URL]">[SITE_NAME] Team<br /></a></p>', 'Resend Activation Link');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('upload_notify_admin', 'New Video Upload at [SITE_NAME] by [USERNAME]', '<p>USER ID: [USER_ID]</p><p>USER IP: [USER_IP]</p><p>USERNAME: [USERNAME]</p><p>TITLE: [TITLE]</p><p>DESCRIPTION: [DESCRIPTION]</p><p>KEYWORDS: [KEYWORDS]</p><p>CHANNEL: [CHANNELS]</p><p>TYPE: [TYPE]</p><p>VIDEO URL: [VIDEO_URL]</p>', 'Admin Notification for video upload');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('abuse_report', 'Abuse report on [VIDEO_TITLE]', '<p>Hi Admin,</p>  <p>Following video is reported as Inappropriate.</p><p><a href="[VIDEO_URL] ">[VIDEO_URL]</a></p><p>Abuse Type: <font color="#000000">[TYPE_ABUSE]</font></p><p>Comments: <font color="#000000">[ABUSE_COMMENTS]</font></p><p>Reported by:</p><p>User Name: [USER_NAME]<br />IP Address: &nbsp;[REMOTE_ADDR]</p><p>Thanks,</p><p><a href="[SITE_URL]">[SITE_NAME]</a></p>', 'Report Inappropriate Video');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('delete_user', '[SITE_NAME] Account Delete Verification - [USERNAME]', '<p>Hi [USERNAME],</p><p>You or some one from IP: [USER_IP] requested to delete the account [USERNAME]</p><p><a href="[SITE_URL]/[USERNAME]">[SITE_URL]/[USERNAME]</a></p><p>To delete the account, click the link below</p><p><a href="[VERIFY_URL]">[VERIFY_URL]</a></p><p>Thank you,</p><p><a href="[SITE_URL]">[SITE_NAME]</a></p>', 'Account delete verification Mail');
INSERT INTO `email_templates` (`email_id` ,`email_subject` ,`email_body` ,`comment`) VALUES('video_response_notify', '[SITE_NAME] - Video response to "[VIDEO_TITLE]"', '<p><a href="[SITE_URL]/[USERNAME]">[USERNAME]</a> has posted a video in response to <a href="[VIDEO_URL]">[VIDEO_TITLE]</a></p> <p>Response Video: <a href="[RESPONSE_VIDEO_URL]">[RESPONSE_VIDEO_TITLE]</a></p><p>This video requires your approval. You can approve or reject it by visiting the following link.</p><p><a href="[VERIFY_LINK]">[VERIFY_LINK]</a></p><p>Thanks</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team</p>', 'video response notify');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('unsubscribe_admin_mail', 'admin mail footer', '<br />\r\n<a href="[UNSUBSCRIBE_URL]" target="_blank">Unsubscribe</a>', 'admin mail footer');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('video_comment_notify', '[SITE_NAME] - Comment posted on your video', '<p>Hello <a href="[SITE_URL]/[VIDEO_OWNER_NAME]">[VIDEO_OWNER_NAME]</a>,</p><p><a href="[SITE_URL]/[COMMENT_USER_NAME]">[COMMENT_USER_NAME]</a> has commented on your video.</p><p>Check it by clicking the following link,</p><p><a href="[VIDEO_URL]">[VIDEO_TITLE]</a></p><p>Thanks,</p><p><a href="[SITE_URL]">[SITE_NAME]</a> Team.</p>', 'video comment notification');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('user_signup', 'Welcome to [SITE_NAME]', '<p>Hi [USERNAME],</p><p>Welcome to [SITE_NAME].</p><p>Please keep this email for your records. Your account information is as follows:</p><p>----------------------------</p><p>Username: [USERNAME]<br>Password: [PASSWORD]<br>Site URL: [SITE_URL]<br></p><p>----------------------------</p><p>Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.</p><p>Thank you for registering.</p><p>Thanks,</p><p>[SITE_NAME] Team.</p>', 'Welcome mail for users after signed up');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('user_signup_verify', 'Welcome to [SITE_NAME]', '<p>Hi [USERNAME],</p><p>Welcome to [SITE_NAME].</p><p>Please keep this email for your records. Your account information is as follows:</p><p>----------------------------</p><p>Username: [USERNAME]<br>Password: [PASSWORD]<br>Site URL: [SITE_URL]<br></p><p>----------------------------</p><p>Please visit the following link in order to activate your account:</p><p>[VERIFY_LINK]</p><p>Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.</p><p>Thank you for registering.</p><p>Thanks,</p><p>[SITE_NAME] Team.</p>', 'Welcome mail for users when signup verification enabled');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('user_signup_verify_admin', 'Welcome to [SITE_NAME]', '<p>Hi [USERNAME],</p><p>Welcome to [SITE_NAME].</p><p>Please keep this email for your records. Your account information is as follows:</p><p>----------------------------</p><p>Username: [USERNAME]<br>Password: [PASSWORD]<br>Site URL: [SITE_URL]<br></p><p>----------------------------</p><p>Your account is currently inactive and will need to be approved by an administrator before you can log in. Another email will be sent when this has occurred.</p><p>Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.</p><p>Thank you for registering.</p><p>Thanks,</p><p>[SITE_NAME] Team.</p>', 'Welcome mail for users, when signup verification by Admin');
INSERT INTO `email_templates` (`email_id`, `email_subject`, `email_body`, `comment`) VALUES('user_signup_verify_admin_active', 'Account activated on [SITE_NAME]', '<p>Hi [USERNAME],</p><p>Your account on "[SITE_NAME]" has been activated by administrator, you may login now.</p><p>Login URL: [SITE_URL]/login/</p><p>Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.</p><p>Thanks,</p><p>[SITE_NAME] Team.</p>', 'Send mails to users after verified by Admin');


-- Table structure for table `favourite`

CREATE TABLE IF NOT EXISTS `favourite` (
  `favourite_user_id` int(11) NOT NULL default '0',
  `favourite_video_id` int(11) NOT NULL default '0',
  UNIQUE KEY `favourite_index` (`favourite_user_id`,`favourite_video_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `favourite`


-- Table structure for table `feature_requests`

CREATE TABLE IF NOT EXISTS `feature_requests` (
  `feature_request_video_id` int(11) NOT NULL default '0',
  `feature_request_count` int(11) NOT NULL default '0',
  `feature_request_date` varchar(10) default NULL,
  PRIMARY KEY  (`feature_request_video_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `feature_requests`


-- Table structure for table `friends`

CREATE TABLE IF NOT EXISTS `friends` (
  `friend_id` int(11) NOT NULL auto_increment,
  `friend_user_id` int(11) NOT NULL default '0',
  `friend_friend_id` int(11) default NULL,
  `friend_name` varchar(100) NOT NULL,
  `friend_type` varchar(255) NOT NULL default 'All',
  `friend_invite_date` date NOT NULL default '0000-00-00',
  `friend_status` enum('Pending','Confirmed','DENIED') NOT NULL default 'Pending',
  PRIMARY KEY  (`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `friends`


-- Table structure for table `groups`

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(120) NOT NULL,
  `group_keyword` text NOT NULL,
  `group_description` text NOT NULL,
  `group_url` varchar(80) NOT NULL,
  `group_channels` varchar(120) NOT NULL,
  `group_type` varchar(40) NOT NULL,
  `group_upload` varchar(40) NOT NULL,
  `group_posting` varchar(40) NOT NULL,
  `group_image` varchar(30) NOT NULL,
  `group_image_video` int(11) default NULL,
  `group_create_time` int(11) NOT NULL,
  `group_featured` char(3) NOT NULL default 'no',
  `group_owner_id` int(20) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  UNIQUE KEY `group_index` (`group_id`,`group_owner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `groups`


-- Table structure for table `group_members`

CREATE TABLE IF NOT EXISTS `group_members` (
  `AID` int(11) NOT NULL auto_increment,
  `group_member_group_id` int(11) NOT NULL default '0',
  `group_member_user_id` int(11) NOT NULL default '0',
  `group_member_since` date NOT NULL default '0000-00-00',
  `group_member_approved` char(3) NOT NULL default 'yes',
  PRIMARY KEY  (`AID`),
  UNIQUE KEY `group_member_group_id` (`group_member_group_id`,`group_member_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `group_members`


-- Table structure for table `group_topics`

CREATE TABLE IF NOT EXISTS `group_topics` (
  `group_topic_id` int(11) NOT NULL auto_increment,
  `group_topic_group_id` int(11) NOT NULL default '0',
  `group_topic_user_id` int(11) NOT NULL default '0',
  `group_topic_add_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `group_topic_title` text NOT NULL,
  `group_topic_video_id` int(11) NOT NULL default '0',
  `group_topic_approved` char(3) NOT NULL default 'yes',
  PRIMARY KEY  (`group_topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `group_topics`


-- Table structure for table `group_topic_posts`

CREATE TABLE IF NOT EXISTS `group_topic_posts` (
  `group_topic_post_id` int(11) NOT NULL auto_increment,
  `group_topic_post_topic_id` int(11) NOT NULL default '0',
  `group_topic_post_user_id` int(11) NOT NULL default '0',
  `group_topic_post_video_id` int(11) default NULL,
  `group_topic_post_description` text NOT NULL,
  `group_topic_post_date` int(11) NOT NULL,
  PRIMARY KEY  (`group_topic_post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `group_topic_posts`


-- Table structure for table `group_videos`

CREATE TABLE IF NOT EXISTS `group_videos` (
  `AID` int(11) NOT NULL auto_increment,
  `group_video_group_id` int(11) NOT NULL default '0',
  `group_video_video_id` int(11) NOT NULL default '0',
  `group_video_member_id` int(11) NOT NULL default '0',
  `group_video_approved` char(3) NOT NULL default 'yes',
  PRIMARY KEY  (`AID`),
  UNIQUE KEY `group_video_index` (`group_video_group_id`,`group_video_video_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `group_videos`


-- Table structure for table `guest_info`

CREATE TABLE IF NOT EXISTS `guest_info` (
  `sl` int(4) NOT NULL auto_increment,
  `guest_ip` varchar(16) NOT NULL default '',
  `log_date` date NOT NULL default '0000-00-00',
  `use_bw` bigint(20) NOT NULL default '0',
  UNIQUE KEY `sl` (`sl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `guest_info`


-- Table structure for table `import_auto`

CREATE TABLE IF NOT EXISTS `import_auto` (
  `import_auto_id` int(11) unsigned NOT NULL auto_increment,
  `import_auto_keywords` text NOT NULL,
  `import_auto_download` int(1) NOT NULL default '0',
  PRIMARY KEY  (`import_auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `import_auto`


-- Table structure for table `import_track`

CREATE TABLE IF NOT EXISTS `import_track` (
  `import_track_id` int(11) NOT NULL auto_increment,
  `import_track_unique_id` varchar(255) NOT NULL,
  `import_track_video_id` INT( 11 ) NOT NULL default '0',
  `import_track_site` varchar(255) NOT NULL,
  PRIMARY KEY  (`import_track_id`),
  UNIQUE KEY `import_track_unique_id` (`import_track_unique_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `import_track`


-- Table structure for table `inappropriate_requests`

CREATE TABLE IF NOT EXISTS `inappropriate_requests` (
  `inappropriate_request_video_id` bigint(20) NOT NULL default '0',
  `inappropriate_request_count` bigint(20) NOT NULL default '0',
  `inappropriate_request_date` varchar(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `inappropriate_requests`


-- Table structure for table `mails`

CREATE TABLE IF NOT EXISTS `mails` (
  `mail_id` bigint(20) NOT NULL auto_increment,
  `mail_subject` varchar(200) NOT NULL,
  `mail_body` text NOT NULL,
  `mail_sender` varchar(40) NOT NULL,
  `mail_receiver` varchar(40) NOT NULL,
  `mail_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `mail_read` tinyint(1) NOT NULL default '0',
  `mail_inbox_track` int(11) NOT NULL default '2',
  `mail_outbox_track` int(11) NOT NULL default '2',
  PRIMARY KEY  (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `mails`


CREATE TABLE IF NOT EXISTS `packages` (
  `package_id` int(11) NOT NULL auto_increment,
  `package_name` varchar(255) NOT NULL,
  `package_description` text NOT NULL,
  `package_space` int(11) NOT NULL DEFAULT '0',
  `package_price` int(11) NOT NULL DEFAULT '0',
  `package_videos` int(11) DEFAULT NULL,
  `package_period` enum('Day','Month','Year') NOT NULL DEFAULT 'Month',
  `package_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `package_trial` char(3) NOT NULL DEFAULT 'no',
  `package_trial_period` int(11) DEFAULT NULL,
  `package_allow_download` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`package_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `packages` VALUES(1, 'FREE TRIAL', 'Free Trial', 200, 0, 100, 'Month', 'Active', 'yes', 600, 0);
INSERT INTO `packages` VALUES(2, 'PLAN 1', 'PLAN 1', 512, 50, 100, 'Month', 'Active', 'no', NULL, 0);
INSERT INTO `packages` VALUES(3, 'PLAN 2', 'PLAN 2', 20100, 100, 501, 'Year', 'Active', 'no', NULL, 0);

-- Table structure for table `pages`

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) unsigned NOT NULL auto_increment,
  `page_name` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_keywords` varchar(255) NOT NULL,
  `page_description` varchar(255) NOT NULL,
  `page_content` mediumtext NOT NULL,
  `page_counter` int(10) unsigned NOT NULL default '0',
  `page_tpl` int(1) NOT NULL default '1',
  `page_members_only` int(1) NOT NULL default '0',
  PRIMARY KEY  (`page_id`),
  UNIQUE KEY `name` (`page_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- Dumping data for table `pages`

INSERT INTO `pages` (`page_id`, `page_name`, `page_title`, `page_keywords`, `page_description`, `page_content`, `page_counter`, `page_tpl`, `page_members_only`) VALUES(1, 'about', 'About us', 'About us', 'About us', '<table width="90%" align="center">\r\n<tr>\r\n<td>\r\n\r\n<h3>About Us ... </h3>\r\n\r\n</td>\r\n</tr>\r\n</table>', 1, 1, 0);
INSERT INTO `pages` (`page_id`, `page_name`, `page_title`, `page_keywords`, `page_description`, `page_content`, `page_counter`, `page_tpl`, `page_members_only`) VALUES(2, 'advertise', 'advertise', 'advertise', 'advertise', '<table width="90%" align="center">\r\n<tr>\r\n<td>\r\n\r\n<h3>Advertise ... </h3>\r\n\r\nYou can advertise with us. For more info, contact us.\r\n\r\n</td>\r\n</tr>\r\n</table>\r\n', 1, 1, 0);
INSERT INTO `pages` (`page_id`, `page_name`, `page_title`, `page_keywords`, `page_description`, `page_content`, `page_counter`, `page_tpl`, `page_members_only`) VALUES(3, 'help', 'help', 'help', 'help', '<table width="90%" align="center">\r\n<tr>\r\n<td>\r\n\r\n<h3>Help</h3>\r\n\r\n<p>For help, visit <a href="http://forums.buyscripts.in">http://forums.buyscripts.in</a></p>\r\n\r\n</td>\r\n</tr>\r\n</table>\r\n', 1, 1, 0);
INSERT INTO `pages` (`page_id`, `page_name`, `page_title`, `page_keywords`, `page_description`, `page_content`, `page_counter`, `page_tpl`, `page_members_only`) VALUES(4, 'terms', 'terms', 'terms', 'terms', '<table width="90%" align="center">\r\n<tr>\r\n<td>\r\n<h3>Terms of Use</h3></td>\r\n</tr>\r\n</table>\r\n', 1, 1, 0);
INSERT INTO `pages` (`page_id`, `page_name`, `page_title`, `page_keywords`, `page_description`, `page_content`, `page_counter`, `page_tpl`, `page_members_only`) VALUES(5, 'privacy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '<table width="90%" align="center">\r\n<tr>\r\n<td>\r\n<h3>Privacy Policy</h3>\r\n</td>\r\n</tr>\r\n</table>\r\n', 0, 1, 0);

-- Table structure for table `playlists`

CREATE TABLE IF NOT EXISTS `playlists_videos` (
`playlists_videos_playlist_id` int( 11 ) NOT NULL DEFAULT 0,
`playlists_videos_video_id` bigint( 20 ) default NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- Dumping data for table `playlists_videos`

-- Table structure for table `playlists`

CREATE TABLE IF NOT EXISTS `playlists` (
`playlist_id` int(11) NOT NULL auto_increment,
`playlist_user_id` int(11) NOT NULL,
`playlist_name` varchar(50) NOT NULL,
`playlist_add_date` varchar(255) NOT NULL,
PRIMARY KEY (`playlist_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- Dumping data for table `playlists`


-- Table structure for table `poll_question`

CREATE TABLE IF NOT EXISTS `poll_question` (
  `poll_id` int(4) NOT NULL auto_increment,
  `poll_qty` varchar(250) NOT NULL default '',
  `poll_answer` text NOT NULL,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `poll_question`


-- Table structure for table `poll_results`

CREATE TABLE IF NOT EXISTS `poll_results` (
  `poll_result_vote_id` varchar(10) NOT NULL,
  `poll_result_voter_id` varchar(20) NOT NULL,
  `poll_result_answer` varchar(250) NOT NULL,
  `poll_result_client_ip` varchar(25) NOT NULL,
  `poll_result_date` date NOT NULL default '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `poll_results`


-- Table structure for table `process_queue`

CREATE TABLE IF NOT EXISTS `process_queue` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `channels` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `url` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `vid` int(11) NOT NULL,
  `process_queue_upload_ip` varchar(20) NOT NULL,
  `import_track_id` INT( 11 ) NOT NULL,
  `adult` TINYINT( 1 ) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `process_queue`


-- Table structure for table `profile_comments`

CREATE TABLE IF NOT EXISTS `profile_comments` (
  `profile_comment_id` int(11) NOT NULL auto_increment,
  `profile_comment_user_id` int(11) NOT NULL default '0',
  `profile_comment_posted_by` int(11) NOT NULL,
  `profile_comment_text` text NOT NULL,
  `profile_comment_ip` varchar(20) NOT NULL,
  `profile_comment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`profile_comment_id`),
  KEY `uid` (`profile_comment_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `profile_comments`


-- Table structure for table `relation`

CREATE TABLE IF NOT EXISTS `relation` (
  `AID` bigint(20) NOT NULL auto_increment,
  `FAID` bigint(20) NOT NULL default '0',
  `FBID` bigint(20) NOT NULL default '0',
  `status` varchar(8) NOT NULL default 'pending',
  `type` varchar(8) NOT NULL default '',
  `e_mail` varchar(80) NOT NULL default '',
  PRIMARY KEY  (`AID`),
  UNIQUE KEY `FAID` (`FAID`,`e_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `relation`


-- Table structure for table `sconfig`

CREATE TABLE IF NOT EXISTS `sconfig` (
  `soption` varchar(60) NOT NULL default '',
  `svalue` varchar(200) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `sconfig`

INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('admin_email', 'info@yourdomain.com');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('admin_name', 'admin');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('site_name', 'Your Site Name');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('admin_pass', '1bd8043e739cef6e260048f10bf4a2a8');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('max_img_size', '200');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('img_max_width', '250');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('img_max_height', '130');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('items_per_page', '4');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('rel_video_per_page', '10');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('recently_viewed_video', '5');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('cache_enable', '0');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('enable_package', 'no');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('paypal_receiver_email', '');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('payment_method', 'Paypal');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('enable_test_payment', 'no');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('meta_description', '');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('meta_keywords', '');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('user_poll', 'Once');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('video_rating', 'Once');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('debug', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('approve', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('notify_signup', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('notify_upload', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('guest_limit', '20000000000');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('watermark_url', 'http://www.yourdomain.com');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('signup_verify', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('version', '3.2');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('paypal_currency', 'USD');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('embed_show', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('embed_type', '0');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('allow_download', '0');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('player_autostart', '0');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('player_bufferlength', '5');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('player_width', '640');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('player_height', '390');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('show_stats', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('adult', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('video_comments_per_page', '5');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('user_comments_per_page', '5');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('num_new_videos', '5');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('num_watch_videos', '20');
INSERT INTO `sconfig` (`soption` ,`svalue`) VALUES('family_filter', '1');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('episode_enable', '0');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('watermark_image_url', '/themes/default/images/watermark.gif');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('logo_url_md', '/themes/default/images/logo.jpg');
INSERT INTO `sconfig` (`soption`, `svalue`) VALUES('logo_url_sm', '/themes/default/images/logo-small.png');

-- Table structure for table `servers`

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  `space_used` int(11) unsigned NOT NULL default '0',
  `server_type` tinyint(1) NOT NULL default '0',
  `server_secdownload_secret` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `servers`


-- Table structure for table `subscriber`

CREATE TABLE IF NOT EXISTS `subscriber` (
  `UID` bigint(20) NOT NULL default '0',
  `pack_id` int(11) NOT NULL default '0',
  `used_space` float unsigned NOT NULL default '0',
  `used_bw` float unsigned NOT NULL default '0',
  `total_video` bigint(20) NOT NULL default '0',
  `subscribe_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `expired_time` datetime NOT NULL default '0000-00-00 00:00:00',
  UNIQUE KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `subscriber`


-- Table structure for table `tags`

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL auto_increment,
  `tag` varchar(255) NOT NULL,
  `tag_count` int(11) NOT NULL default '0',
  `used_on` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `tags`


-- Table structure for table `tag_video`

CREATE TABLE IF NOT EXISTS `tag_video` (
  `id` int(11) NOT NULL auto_increment,
  `tag_id` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `chid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `tag_video`


-- Table structure for table `users`

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL auto_increment,
  `user_email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_salt` varchar(255) NOT NULL,
  `user_first_name` varchar(40) NOT NULL,
  `user_last_name` varchar(40) NOT NULL,
  `user_birth_date` date NOT NULL default '0000-00-00',
  `user_gender` varchar(6) NOT NULL,
  `user_relation` varchar(8) NOT NULL,
  `user_about_me` text NOT NULL,
  `user_website` varchar(120) NOT NULL,
  `user_town` varchar(80) NOT NULL,
  `user_city` varchar(80) NOT NULL,
  `user_zip` varchar(30) NOT NULL,
  `user_country` varchar(80) NOT NULL,
  `user_occupation` text NOT NULL,
  `user_company` text NOT NULL,
  `user_school` text NOT NULL,
  `user_interest_hobby` text NOT NULL,
  `user_fav_movie_show` text NOT NULL,
  `user_fav_music` text NOT NULL,
  `user_fav_book` text NOT NULL,
  `user_friends_type` varchar(255) NOT NULL default 'All|Family|Friends',
  `user_video_viewed` int(10) NOT NULL default '0',
  `user_profile_viewed` int(10) NOT NULL default '0',
  `user_watched_video` int(10) NOT NULL default '0',
  `user_join_time` varchar(20) NOT NULL,
  `user_last_login_time` varchar(20) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `user_email_verified` char(3) NOT NULL default 'no',
  `user_subscribe_admin_mail` tinyint(1) NOT NULL default '1',
  `user_account_status` enum('Active','Inactive','Suspended') NOT NULL default 'Active',
  `user_vote` varchar(5) NOT NULL,
  `user_rated_by` varchar(5) NOT NULL default '0',
  `user_rate` varchar(5) NOT NULL default '0',
  `user_parents_name` varchar(50) NOT NULL,
  `user_parents_email` varchar(50) NOT NULL,
  `user_friends_name` varchar(50) NOT NULL,
  `user_friends_email` varchar(50) NOT NULL,
  `user_adult` tinyint(1) NOT NULL default '0',
  `user_photo` tinyint(1) NOT NULL default '0',
  `user_background` tinyint(1) NOT NULL default '0',
  `user_style` varchar(255) NOT NULL,
  `user_friend_invition` tinyint(1) NOT NULL default '1',
  `user_private_message` tinyint(1) NOT NULL default '1',
  `user_profile_comment` tinyint(1) NOT NULL default '1',
  `user_favourite_public` tinyint(1) NOT NULL default '1',
  `user_playlist_public` tinyint(1) NOT NULL default '1',
  `user_videos` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `users`


-- Table structure for table `uservote`

CREATE TABLE IF NOT EXISTS `uservote` (
  `candate_id` varchar(15) NOT NULL default '',
  `voter_id` varchar(15) NOT NULL default '',
  `vote` char(2) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table `uservote`


-- Table structure for table `user_logins`

CREATE TABLE IF NOT EXISTS `user_logins` (
  `user_login_id` int(11) NOT NULL auto_increment,
  `user_login_user_id` int(11) NOT NULL,
  `user_login_time` int(11) NOT NULL,
  `user_login_ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`user_login_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `user_logins`


-- Table structure for table `verify_code`

CREATE TABLE IF NOT EXISTS `verify_code` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `vkey` varchar(255) NOT NULL,
  `data1` varchar(255) NOT NULL,
  `data2` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `verify_code`


-- Table structure for table `videos`

CREATE TABLE IF NOT EXISTS `videos` (
  `video_id` bigint(20) NOT NULL auto_increment,
  `video_user_id` bigint(20) NOT NULL default '0',
  `video_seo_name` varchar(255) NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `video_description` text NOT NULL,
  `video_keywords` text NOT NULL,
  `video_channels` varchar(255) NOT NULL default '0|',
  `video_name` varchar(255) NOT NULL,
  `video_flv_name` varchar(255) default NULL,
  `video_duration` float NOT NULL default '0',
  `video_length` varchar(255) default NULL,
  `video_space` float unsigned NOT NULL default '0',
  `video_type` varchar(7) NOT NULL,
  `video_vtype` int(2) NOT NULL,
  `video_add_time` varchar(20) default NULL,
  `video_add_date` date NOT NULL default '0000-00-00',
  `video_record_date` date NOT NULL default '0000-00-00',
  `video_location` text NOT NULL,
  `video_country` varchar(120) NOT NULL,
  `video_view_number` int(11) NOT NULL default '0',
  `video_view_time` int(11) NOT NULL,
  `video_com_num` int(8) NOT NULL default '0',
  `video_fav_num` int(8) NOT NULL default '0',
  `video_featured` char(3) NOT NULL default 'no',
  `video_rated_by` int(10) NOT NULL default '0',
  `video_rate` float NOT NULL default '0',
  `video_allow_comment` char(3) NOT NULL default 'yes',
  `video_allow_rated` char(3) NOT NULL default 'yes',
  `video_allow_embed` varchar(8) NOT NULL default 'enabled',
  `video_embed_code` text,
  `video_voter_id` varchar(255) NOT NULL,
  `video_active` tinyint(1) NOT NULL default '0',
  `video_approve` tinyint(1) NOT NULL default '0',
  `video_adult` tinyint(1) NOT NULL default '0',
  `video_server_id` int(1) NOT NULL default '0',
  `video_thumb_server_id` int(11) unsigned NOT NULL default '0',
  `video_folder` varchar(255) NOT NULL,
  PRIMARY KEY  (`video_id`),
  FULLTEXT KEY `video_title` (`video_title`),
  FULLTEXT KEY `video_description` (`video_description`),
  FULLTEXT KEY `video_keywords` (`video_keywords`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `videos`


-- Table structure for table `view_log`

CREATE TABLE IF NOT EXISTS `view_log` (
  `view_log_id` int(1) NOT NULL auto_increment,
  `view_log_video_id` int(11) NOT NULL,
  `view_log_ip` varchar(255) NOT NULL,
  `view_log_time` int(11) NOT NULL,
  PRIMARY KEY  (`view_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `view_log`


-- Table structure for table `words`

CREATE TABLE IF NOT EXISTS `words` (
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word` varchar(255) NOT NULL default '',
  `replacement` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`word_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Dumping data for table `words`
--

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

-- Table structure for table `video_responses`

CREATE TABLE IF NOT EXISTS `video_responses` (
  `video_response_id` int(11) NOT NULL auto_increment,
  `video_response_video_id` int(11) NOT NULL,
  `video_response_to_video_id` int(11) NOT NULL,
  `video_response_active` int(1) NOT NULL default '0',
  `video_response_add_time` int(11) NOT NULL,
  PRIMARY KEY  (`video_response_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- Dumping data for table `video_responses`

CREATE TABLE IF NOT EXISTS `sitemap` (
  `sitemap_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `sitemap_name` VARCHAR( 255 ) NOT NULL ,
  `sitemap_create_date` INT( 11 ) NOT NULL ,
  `sitemap_url_count` INT( 11 ) NOT NULL default '0',
  `sitemap_size` INT( 11 ) NOT NULL ,
  `sitemap_last_video_id` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Table structure for table `mail_logs`

CREATE TABLE `mail_logs` (
  `mail_log_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `mail_log_user_id` INT( 11 ) NOT NULL ,
  `mail_log_time` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8;

--
-- Table structure for table `banned_ips`
--

CREATE TABLE IF NOT EXISTS `banned_ips` (
  `id` int(12) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ip` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `payments` (
`payment_id` int(11) unsigned NOT NULL auto_increment,
  `payment_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_completed` smallint(1) NOT NULL DEFAULT '0',
  `payment_package_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_period` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
   PRIMARY KEY  (`payment_id`),
   KEY `payment_hash` (`payment_hash`)
);

CREATE TABLE IF NOT EXISTS `episodes` (
  `episode_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `episode_name` varchar(255) NOT NULL
) ENGINE=MYISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `episode_videos` (
  `ep_video_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ep_video_eid` int(11) NOT NULL DEFAULT '0',
  `ep_video_vid` int(11) NOT NULL DEFAULT '0',
  `ep_video_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=MYISAM DEFAULT CHARSET=utf8 ;
