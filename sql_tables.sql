CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `start` int(11) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `end` int(11) DEFAULT NULL,
  `state` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fleets` (
  `moveId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `shipId` int(11) NOT NULL,
  KEY `moveId` (`moveId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `category` varchar(25) NOT NULL,
  `type` varchar(25) DEFAULT NULL,
  `modulesMax` int(11) NOT NULL,
  `loadMax` int(11) NOT NULL,
  `energyMax` int(11) NOT NULL,
  `energyGain` int(11) NOT NULL,
  `fuelMax` int(11) NOT NULL,
  `powerMax` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `zone` int(11) DEFAULT NULL,
  `category` varchar(10) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `positions_searches` (
  `positionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `result` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ressources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `into` varchar(10) NOT NULL,
  `intoId` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `model` int(11) NOT NULL,
  `positionId` int(11) NOT NULL,
  `load` float NOT NULL,
  `energy` float NOT NULL,
  `power` float NOT NULL,
  `lastUpdate` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(12) NOT NULL,
  `password` varchar(70) NOT NULL,
  `mail` text NOT NULL,
  `rank` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_positions` (
  `userId` int(11) NOT NULL,
  `positionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ships_modules` (
  `shipId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL,
  `moduleOrder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `intro` text NOT NULL,
  `description` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `weight` int(11) NOT NULL,
  `power` int(11) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `load` int(11) DEFAULT NULL,
  `fuel` int(11) DEFAULT NULL,
  `techs` int(11) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `shield` int(11) DEFAULT NULL,
  `search` int(11) DEFAULT NULL,
  `attack` int(11) DEFAULT NULL,
  `weapons` int(11) DEFAULT NULL,
  `defense` int(11) DEFAULT NULL,
  `costEnergy` int(11) NOT NULL,
  `costTechs` int(11) NOT NULL,
  `costFuel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

ALTER TABLE  `modules` CHANGE  `weight`  `weight` FLOAT( 11 ) NOT NULL ,
CHANGE  `power`  `power` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `energy`  `energy` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `load`  `load` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `fuel`  `fuel` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `techs`  `techs` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `speed`  `speed` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `shield`  `shield` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `search`  `search` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `attack`  `attack` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `weapons`  `weapons` FLOAT( 11 ) NULL DEFAULT NULL ,
CHANGE  `defense`  `defense` FLOAT( 11 ) NULL DEFAULT NULL ;

