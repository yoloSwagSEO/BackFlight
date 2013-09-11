CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(12) NOT NULL,
  `password` varchar(70) NOT NULL,
  `mail` text NOT NULL,
  `rank` varchar(10) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `zone` int(11) NOT NULL,
  `category` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `positionId` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `positions` CHANGE  `zone`  `zone` INT( 11 ) NULL ;
ALTER TABLE  `ships` CHANGE  `playerId`  `userId` INT( 11 ) NOT NULL ;
ALTER TABLE  `ships` ADD  `model` INT NOT NULL AFTER  `type` ;