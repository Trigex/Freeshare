CREATE TABLE `verify_password` (
`id` INT NOT NULL AUTO_INCREMENT ,
`uid` INT NOT NULL ,
`vcode` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `id` )
);


INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'signup_verify', '1');
INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'signup_captcha', '1');
INSERT INTO `sconfig` ( `soption` , `svalue` )  VALUES ( 'version', '20070522');
