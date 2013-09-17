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

CREATE TABLE IF NOT EXISTS `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `category` varchar(25) NOT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `moves` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user` INT(11) NOT NULL,
    `type` varchar(25) NOT NULL,
    `from` INT(11) NOT NULL,
    `to` INT(11) NOT NULL,
    `start` INT(11) NULL,
    `duration` INT(11) NOT NULL,
    `end` INT(11) NULL,
    `state` varchar(25) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fleets` (
  `moveId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `shipId` int(11) NOT NULL,
  KEY `moveId` (`moveId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `models` ADD  `loadMax` INT NOT NULL ,
ADD  `energyMax` INT NOT NULL ,
ADD  `fuelMax` INT NOT NULL ,
ADD  `powerMax` INT NOT NULL ,
ADD  `speed` INT NOT NULL ;
