DROP TABLE IF EXISTS `words`;

CREATE TABLE `words` (
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word` varchar(255) NOT NULL default '',
  `replacement` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`word_id`)
);

DROP TABLE IF EXISTS `disallow`;

CREATE TABLE disallow (
  `disallow_id` mediumint(8) unsigned NOT NULL auto_increment,
  `disallow_username` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`disallow_id`)
);

INSERT INTO `disallow` VALUES (1, 'admin');

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `keywords` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `counter` int(10) unsigned NOT NULL default '0',
  `tpl` int(1) NOT NULL default '1',
  `members_only` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
);


ALTER TABLE `channel` ADD `sortorder` INT( 2 ) DEFAULT '1' NOT NULL ;
INSERT INTO `sconfig` ( `soption` , `svalue` ) VALUES ('paypal_currency', 'USD');
ALTER TABLE `comments` DROP INDEX `VID` , ADD INDEX `VID` ( `VID` , `UID` );
UPDATE `sconfig` SET `svalue` = '20070625' WHERE `soption` = 'version';
