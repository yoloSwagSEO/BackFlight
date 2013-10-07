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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL,
  `moduleOrder` int(11) DEFAULT NULL,
  `moduleEnabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `intro` text NOT NULL,
  `description` text NOT NULL,
  `type` varchar(15) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `weight` float NOT NULL,
  `power` float DEFAULT NULL,
  `energy` float DEFAULT NULL,
  `load` float DEFAULT NULL,
  `fuel` float DEFAULT NULL,
  `techs` float DEFAULT NULL,
  `speed` float DEFAULT NULL,
  `shield` float DEFAULT NULL,
  `search` float DEFAULT NULL,
  `attack` float DEFAULT NULL,
  `weapons` float DEFAULT NULL,
  `defense` float DEFAULT NULL,
  `costEnergy` int(11) NOT NULL,
  `costTechs` int(11) NOT NULL,
  `costFuel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE  `modules` CHANGE  `name`  `name` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;

CREATE TABLE IF NOT EXISTS `builds` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `type` varchar(25) NOT NULL,
    `typeId` INT(11) NOT NULL,
    `userId` INT(11) NOT NULL,
    `destination` varchar(25) NOT NULL,
    `destinationId` INT(11) NOT NULL,
    `start` INT(11) NOT NULL,
    `end` INT(11) NOT NULL,
    `state` varchar(25) NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `modules` ADD  `time` INT NOT NULL AFTER  `operation` ;

ALTER TABLE  `models` ADD  `shieldMax` INT NOT NULL AFTER  `energyGain` ,
ADD  `shieldGain` INT NOT NULL AFTER  `shieldMax` ;
ALTER TABLE  `ships` ADD  `shield` INT NOT NULL AFTER  `energy` ;

ALTER TABLE  `modules` ADD  `energyGain` FLOAT NULL AFTER  `energy` ;
ALTER TABLE  `modules` ADD  `shieldGain` FLOAT NULL AFTER  `shield` ;

CREATE TABLE IF NOT EXISTS `quests` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL,
    `intro` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `positionId` INT(11) NOT NULL,
    `questType` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `quests_steps` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `questId` INT(11) NOT NULL,
    `stepName` varchar(30) NOT NULL,
    `stepDescription` text NOT NULL,
    `stepPositionId` INT(11) NOT NULL,
    `stepNb` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `quests_requirements` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `questId` INT(11) NOT NULL,
    `stepId` INT(11) NOT NULL,
    `requirementType` varchar(15) NOT NULL,
    `requirementValue` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `quests_gains` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `questId` INT(11) NOT NULL,
    `stepId` INT(11) NOT NULL,
    `gainType` varchar(25) NOT NULL,
    `gainQuantity` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;