CREATE TABLE IF NOT EXISTS `#__mec_events` (
  `id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `repeat` tinyint(4) NOT NULL DEFAULT '0',
  `rinterval` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `month` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `day` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `week` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `weekday` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `weekdays` varchar(255) COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

ALTER TABLE `#__mec_events` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `ID` (`id`), ADD UNIQUE KEY `post_id` (`post_id`), ADD KEY `repeat` (`repeat`);
ALTER TABLE `#__mec_events` MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `#__mec_events` ADD `days` TEXT NULL DEFAULT NULL, ADD `time_start` INT(10) NOT NULL DEFAULT '0', ADD `time_end` INT(10) NOT NULL DEFAULT '0';

ALTER TABLE `#__mec_events` ADD `not_in_days` TEXT NOT NULL DEFAULT '' AFTER `days`;
ALTER TABLE `#__mec_events` CHANGE `days` `days` TEXT NOT NULL DEFAULT '';