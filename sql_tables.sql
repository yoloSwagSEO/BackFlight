CREATE DATABASE IF NOT EXISTS `backflight` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `backflight`;

CREATE TABLE `actions` (
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

CREATE TABLE `builds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `typeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `destination` varchar(25) NOT NULL,
  `destinationId` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `state` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `conversations_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messageId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `conversations_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversationId` int(11) NOT NULL,
  `userFrom` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `read` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `conversations_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversationId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `fleets` (
  `moveId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `shipId` int(11) NOT NULL,
  KEY `moveId` (`moveId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `category` varchar(25) NOT NULL,
  `type` varchar(25) DEFAULT NULL,
  `modulesMax` int(11) NOT NULL,
  `loadMax` int(11) NOT NULL,
  `energyMax` int(11) NOT NULL,
  `energyGain` int(11) NOT NULL,
  `shieldMax` int(11) NOT NULL,
  `shieldGain` int(11) NOT NULL,
  `fuelMax` int(11) NOT NULL,
  `powerMax` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `intro` text NOT NULL,
  `description` text NOT NULL,
  `type` varchar(15) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `time` int(11) NOT NULL,
  `weight` float NOT NULL,
  `power` float DEFAULT NULL,
  `energy` float DEFAULT NULL,
  `energyGain` float DEFAULT NULL,
  `load` float DEFAULT NULL,
  `fuel` float DEFAULT NULL,
  `techs` float DEFAULT NULL,
  `speed` float DEFAULT NULL,
  `shield` float DEFAULT NULL,
  `shieldGain` float DEFAULT NULL,
  `search` float DEFAULT NULL,
  `attack` float DEFAULT NULL,
  `weapons` float DEFAULT NULL,
  `defense` float DEFAULT NULL,
  `module` int(11) DEFAULT NULL,
  `costEnergy` int(11) NOT NULL,
  `costTechs` int(11) NOT NULL,
  `costFuel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `importance` int(11) NOT NULL,
  `into` varchar(10) DEFAULT NULL,
  `intoId` int(11) DEFAULT NULL,
  `type` varchar(25) NOT NULL,
  `typeId` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `actionType` varchar(25) DEFAULT NULL,
  `actionId` int(11) DEFAULT NULL,
  `actionSub` int(11) DEFAULT NULL,
  `read` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `zone` int(11) DEFAULT NULL,
  `category` varchar(10) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `positions_searches` (
  `positionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `result` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `intro` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `positionId` int(11) DEFAULT NULL,
  `questType` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `quests_gains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questId` int(11) NOT NULL,
  `stepId` int(11) DEFAULT NULL,
  `gainOperation` varchar(10) NOT NULL,
  `gainType` varchar(25) NOT NULL,
  `gainValue` int(11) DEFAULT NULL,
  `gainQuantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `quests_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questId` int(11) NOT NULL,
  `stepId` int(11) NOT NULL,
  `requirementType` varchar(15) NOT NULL,
  `requirementValue` int(11) NOT NULL,
  `requirementQuantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `quests_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questId` int(11) NOT NULL,
  `stepName` varchar(30) NOT NULL,
  `stepDescription` text NOT NULL,
  `stepPositionId` int(11) DEFAULT NULL,
  `stepNb` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `ressources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `into` varchar(10) NOT NULL,
  `intoId` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `ships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `model` int(11) NOT NULL,
  `positionId` int(11) NOT NULL,
  `load` float NOT NULL,
  `energy` float NOT NULL,
  `shield` int(11) NOT NULL,
  `power` float NOT NULL,
  `lastUpdate` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `ships_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL,
  `moduleOrder` int(11) DEFAULT NULL,
  `moduleEnabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(12) NOT NULL,
  `password` varchar(70) NOT NULL,
  `mail` text NOT NULL,
  `rank` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `users_positions` (
  `userId` int(11) NOT NULL,
  `positionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questId` int(11) NOT NULL,
  `questState` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users_quests_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `requirementId` int(11) NOT NULL,
  `requirementQuantity` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users_quests_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `stepId` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `conversations_read` (
  `messageId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `conversations_messages`
  DROP `subject`,
  DROP `read`;
  
ALTER TABLE  `conversations_users` ADD  `date` INT NOT NULL ;

CREATE TABLE IF NOT EXISTS `ranks` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `userId` INT(11) NOT NULL,
    `date` INT(11) NOT NULL,
    `distance` FLOAT(20) NOT NULL,
    `ressources` FLOAT(20) NOT NULL,
    `position` FLOAT(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `positions_searches` ADD  `quantity` INT NOT NULL ;
ALTER TABLE  `positions_searches` ADD  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;
ALTER TABLE  `actions` ADD  `distance` INT NULL AFTER  `duration` ;
ALTER TABLE  `actions` CHANGE  `distance`  `distance` FLOAT( 20 ) NULL DEFAULT NULL ;

CREATE TABLE IF NOT EXISTS `objects_users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `objectType` varchar(25) NOT NULL,
    `objectModel` INT(11) NOT NULL,
    `objectUserId` INT(11) NOT NULL,
    `objectFrom` varchar(25) NOT NULL,
    `objectFromId` INT(11) NOT NULL,
    `objectTo` varchar(25) NOT NULL,
    `objectToId` INT(11) NULL,
    `objectStart` INT(11) NOT NULL,
    `objectState` varchar(25) NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `objects` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `objectName` varchar(25) NOT NULL,
    `objectDescription` text NOT NULL,
    `objectType` varchar(25) NOT NULL,
    `objectAttackType` INT(11) NULL,
    `objectAttackPower` INT(11) NULL,
    `objectRange` INT(11) NULL,
    `objectSpeed` INT(11) NULL,
    `objectWeight` INT(11) NOT NULL,
    `objectCostTechs` INT(11) NOT NULL,
    `objectCostFuel` INT(11) NOT NULL,
    `objectCostEnergy` INT(11) NOT NULL,
    `objectLaunchFuel` INT(11) NULL,
    `objectLaunchEnergy` INT(11) NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;