DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`) VALUES
(1,	'test',	'admin',	'202cb962ac59075b964b07152d234b70',	'admin@gmail.com',	1,	'2022-11-30 04:15:49',	0,	'2022-12-06 11:11:26',	1);

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `access` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` tinyint(3) unsigned NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_groups` (`id`, `name`, `description`, `access`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`) VALUES
(1,	'Super User',	'',	'[\"user_manager\",\"usergroup_manager\"]',	1,	'2022-12-06 11:11:19',	1,	'2022-12-06 11:11:19',	1);

DROP TABLE IF EXISTS `user_usergroup_map`;
CREATE TABLE `user_usergroup_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_usergroup_map` (`id`, `user_id`, `group_id`) VALUES
(1,	1,	1);