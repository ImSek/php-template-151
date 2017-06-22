-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` varchar(255) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `content`) VALUES
(1,	1,	1,	'Cool post man!');

DROP TABLE IF EXISTS `like`;
CREATE TABLE `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `isDislike` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `like_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `like` (`id`, `user_id`, `post_id`, `isDislike`) VALUES
(1,	1,	1,	0);

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `content` varchar(500) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `post` (`id`, `user_id`, `title`, `content`) VALUES
(1,	1,	'My first post',	'This is my first post!');

DROP TABLE IF EXISTS `right`;
CREATE TABLE `right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `cancratecontent` tinyint(4) NOT NULL,
  `candeleteanycontent` tinyint(4) NOT NULL,
  `cancreateuser` tinyint(4) NOT NULL,
  `candeleteuser` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `right` (`id`, `name`, `cancratecontent`, `candeleteanycontent`, `cancreateuser`, `candeleteuser`) VALUES
(1,	'admin',	1,	1,	1,	1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `right_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `right_id` (`right_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`right_id`) REFERENCES `right` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `right_id`, `email`, `password`, `username`) VALUES
(1,	1,	'livio.1234567890@gmail.com',	'12345',	'Livio');

-- 2017-06-18 12:47:14
