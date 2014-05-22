-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 04, 2009 at 01:50 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `chat`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `actions`
-- 

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `id` int(11) NOT NULL auto_increment,
  `reason` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `action_time` bigint(20) NOT NULL default '0',
  `chat_id` int(11) NOT NULL default '0',
  `users_id` int(11) NOT NULL default '0',
  `banip` varchar(32) NOT NULL default '0',
  `banuser` varchar(32) NOT NULL default '0',
  `action_by` varchar(50) NOT NULL default 'none',
  `action_on` varchar(50) NOT NULL default 'none',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`,`action_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Actions Logs';

-- 
-- Dumping data for table `actions`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `chat_config`
-- 

DROP TABLE IF EXISTS `chat_config`;
CREATE TABLE `chat_config` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `var_name` varchar(40) NOT NULL default '',
  `var_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

-- 
-- Dumping data for table `chat_config`
-- 

INSERT INTO `chat_config` VALUES (0, 86, 'ChDK_max_msg_time_back', '500');
INSERT INTO `chat_config` VALUES (0, 95, 'ChDK_max_msg_on_enter', '20');
INSERT INTO `chat_config` VALUES (0, 46, 'LTTpl_css_link', './templates/standard/css/default.css');
INSERT INTO `chat_config` VALUES (0, 81, 'ChRefreshAfter', '1500');
INSERT INTO `chat_config` VALUES (0, 94, 'LTChart_offline_user_after', '120');
INSERT INTO `chat_config` VALUES (0, 69, 'LTChat_md5_passwords', '1');
INSERT INTO `chat_config` VALUES (0, 66, 'LTChart_delete_offline_data', '3600');
INSERT INTO `chat_config` VALUES (0, 93, 'LTChatCore_guest_account', '1');

-- --------------------------------------------------------

-- 
-- Table structure for table `check`
-- 

DROP TABLE IF EXISTS `check`;
CREATE TABLE `check` (
  `id` int(11) NOT NULL auto_increment,
  `users_id` int(11) NOT NULL default '0',
  `action_time` bigint(20) NOT NULL,
  `jail` enum('0','1') NOT NULL default '0',
  `kick` enum('0','1') NOT NULL default '0',
  `banuser` enum('0','1') NOT NULL default '0',
  `banip` enum('0','1') NOT NULL default '0',
  `xban` enum('0','1') NOT NULL default '0',
  `sus` enum('0','1') NOT NULL default '0',
  `chat_id` int(11) NOT NULL default '0',
  `mkick` enum('0','1') NOT NULL default '0',
  `away` int(1) NOT NULL default '0',
  `disable` enum('0','1') NOT NULL default '0',
  `flood` enum('0','1') NOT NULL default '0',
  `clear` enum('0','1') NOT NULL default '0',
  `filter` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `friends`
-- 

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `from_users_id` int(11) NOT NULL default '0',
  `to_users_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `friends`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `g_id` int(3) unsigned NOT NULL auto_increment,
  `g_title` varchar(60) default NULL,
  `g_name` varchar(60) default NULL,
  `crlogs` tinyint(1) default NULL,
  `actionstop` tinyint(1) default NULL,
  `upgrade` tinyint(1) default NULL,
  `downgrade` tinyint(1) default NULL,
  `changepass` tinyint(1) default NULL,
  `create` tinyint(1) default NULL,
  `showclear` tinyint(1) default NULL,
  `showfilter` tinyint(1) default NULL,
  `showforward` tinyint(1) default NULL,
  `check` tinyint(1) default NULL,
  `actionlogs` tinyint(1) default NULL,
  `usermsg` tinyint(1) default NULL,
  `opmsg` tinyint(1) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `groups`
-- 

INSERT INTO `groups` VALUES (1, 'Team Members', 'staff', 1, 1, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, NULL);
INSERT INTO `groups` VALUES (2, 'ADV Team', 'adv', NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, 1, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `ignore`
-- 

DROP TABLE IF EXISTS `ignore`;
CREATE TABLE `ignore` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `from_users_id` int(11) NOT NULL default '0',
  `to_users_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `ignore`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `logs`
-- 

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL auto_increment,
  `reason` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `room` varchar(50) NOT NULL,
  `action_time` bigint(20) NOT NULL default '0',
  `action_by` varchar(50) NOT NULL,
  `action_on` varchar(50) NOT NULL,
  `chat_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`,`action_time`,`action_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Reason Logs';

DROP TABLE IF EXISTS `pmessages`;
CREATE TABLE `pmessages` (
  `title` varchar(255) NOT NULL default 'Untitled Message',
  `message` text NOT NULL,
  `touser` varchar(255) NOT NULL default '',
  `from` varchar(255) NOT NULL default '',
  `unread` varchar(255) NOT NULL default 'unread',
  `date` date NOT NULL default '0000-00-00',
  `id` int(15) NOT NULL auto_increment,
  `reply` varchar(15) NOT NULL default 'no',
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `touser` (`touser`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `private_talk`
-- 

DROP TABLE IF EXISTS `private_talk`;
CREATE TABLE `private_talk` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `users_id_from` int(11) NOT NULL default '0',
  `users_id_to` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `time` int(11) NOT NULL default '0',
  `delivered_from` enum('0','1') NOT NULL default '0',
  `delivered_to` enum('0','1') NOT NULL default '0',
  `changed` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `room_cat` varchar(40) NOT NULL default '',
  `room_name` varchar(40) NOT NULL default '',
  `default` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `rooms`
-- 

INSERT INTO `rooms` VALUES (0, 1, 'Rooms', 'Arabia', '1');

-- --------------------------------------------------------

-- 
-- Table structure for table `signup`
-- 

DROP TABLE IF EXISTS `signup`;
CREATE TABLE `signup` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `firstname` varchar(255) default NULL,
  `emailaddress` varchar(255) default NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `signup`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `talk`
-- 

DROP TABLE IF EXISTS `talk`;
CREATE TABLE `talk` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(40) NOT NULL default '',
  `room` varchar(40) NOT NULL default '',
  `text` text NOT NULL,
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `timer`;
CREATE TABLE `timer` (
  `id` int(11) NOT NULL auto_increment,
  `users_id` int(11) NOT NULL,
  `time_log` bigint(20) NOT NULL,
  `total_time` bigint(20) NOT NULL default '0',
  `chat_id` int(11) NOT NULL default '0',
  `login_time` bigint(20) NOT NULL default '0',
  `date` varchar(10) NOT NULL default '',
  `monthly` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `nick` varchar(32) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `picture_url` varchar(255) default NULL,
  `registered` int(11) NOT NULL default '0',
  `posted_msg` int(11) NOT NULL default '0',
  `last_seen` int(11) NOT NULL default '0',
  `last_host` varchar(20) NOT NULL default '',
  `last_ip` varchar(16) NOT NULL default '',
  `level` tinyint(5) NOT NULL default '0',
  `color` varchar(10) NOT NULL default '',
  `nickcolor` varchar(10) NOT NULL default '',
  `font` varchar(50) NOT NULL default '',
  `nickfont` varchar(50) NOT NULL default '',
  `rights` varchar(32) NOT NULL default 'Guest',
  `email` varchar(50) NOT NULL default '0',
  `comment` text NOT NULL,
  `last_pcip` varchar(16) NOT NULL default '',
  `mygroup` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nick` (`nick`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES (0, 50, 'Chat System', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 0, 1178946283, '', '', 51, '#FF66FF', 'FF99FF', 'Tahoma', 'Tahoma', 'Admin', '0', '', '', NULL);
INSERT INTO `users` VALUES (0, 1, 'hany', 'f88e6e106ca9911db8034f61df7f7f23', NULL, 0, 111, 1231014415, '', '127.0.0.1', 50, '', '', '', '', 'Admin', '0', '', 'NONE', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `users_var`
-- 

DROP TABLE IF EXISTS `users_var`;
CREATE TABLE `users_var` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `users_var_names_id` int(11) NOT NULL default '0',
  `users_id` int(11) NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `users_var`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `users_var_names`
-- 

DROP TABLE IF EXISTS `users_var_names`;
CREATE TABLE `users_var_names` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `var_name` varchar(255) NOT NULL default '',
  `var_type` enum('integer','float','text','date','select','radio','textarea') NOT NULL default 'integer',
  `var_length` int(11) NOT NULL default '0',
  `options` text,
  `required` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `users_var_names`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wait`
-- 

DROP TABLE IF EXISTS `wait`;
CREATE TABLE `wait` (
  `id` int(11) NOT NULL auto_increment,
  `nick` varchar(32) NOT NULL default '',
  `ip` varchar(12) NOT NULL default '',
  `users_id` int(11) NOT NULL default '0',
  `chat_id` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `nick` (`nick`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='waiting list';

-- --------------------------------------------------------

-- 
-- Table structure for table `who_is_online`
-- 

DROP TABLE IF EXISTS `who_is_online`;
CREATE TABLE `who_is_online` (
  `chat_id` int(11) NOT NULL default '0',
  `who_id` int(11) NOT NULL auto_increment,
  `users_id` int(11) NOT NULL default '0',
  `online` enum('0','1') NOT NULL default '0',
  `room` varchar(40) NOT NULL default '',
  `action_time` bigint(20) NOT NULL default '0',
  `session_life` varchar(60) NOT NULL,
  PRIMARY KEY  (`who_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
