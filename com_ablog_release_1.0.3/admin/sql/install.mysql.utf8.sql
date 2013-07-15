CREATE TABLE IF NOT EXISTS `#__ablog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__ablog_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_date` datetime NOT NULL,
  `email_adress` varchar(120) NOT NULL,
  `creator` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `comment_answer_id` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__ablog_comment_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `published` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__ablog_posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_date` datetime DEFAULT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL,
  `ordering` int(11) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `creator` varchar(100) NOT NULL,
  `creator_username` varchar(100) NOT NULL,
  `categorie_id` tinyint(4) NOT NULL,
  `trashed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;