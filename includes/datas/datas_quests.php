<?php 
// If there is no quest, we have to create quests, steps, requirements and gains
$FirstQuest = new Quest();
$FirstQuest->setName('A la recherche des techs perdues');
$FirstQuest->setIntro('Qui cherche des techs récolte des techs !');
$FirstQuest->setDescription('Effectuez trois recherches réussies et doublez vos gains !');
$PositionQuest = Position::getClearPosition();
$FirstQuest->setPositionId($PositionQuest->getId());
$FirstQuest->setQuestType('resources');
$FirstQuest->save();

$FirstQuestStep1 = new QuestStep();
$FirstQuestStep1->setQuestId($FirstQuest->getId());
$FirstQuestStep1->setStepDescription('Effectuer trois recherches réussies. <br />Puis revenez en '.$PositionQuest->getX().':'.$PositionQuest->getY().' pour obtenir votre récompense.');
$FirstQuestStep1->setStepName('Trois recherches');
$FirstQuestStep1->setStepNb(1);
$FirstQuestStep1->save();

$FirstQuestStep1Requirement = new QuestRequirement();
$FirstQuestStep1Requirement->setQuestId($FirstQuest->getId());
$FirstQuestStep1Requirement->setStepId($FirstQuestStep1->getId());
$FirstQuestStep1Requirement->setRequirementType('searches');
$FirstQuestStep1Requirement->setRequirementValue(3);
$FirstQuestStep1Requirement->save();

$FirstQuestStep1RequirementGainTechs = new QuestGain();
$FirstQuestStep1RequirementGainTechs->setQuestId($FirstQuest->getId());
$FirstQuestStep1RequirementGainTechs->setStepId($FirstQuestStep1->getId());
$FirstQuestStep1RequirementGainTechs->setGainOperation('multiply');
$FirstQuestStep1RequirementGainTechs->setGainQuantity(2);

$FirstQuestStep1RequirementGainFuel = clone($FirstQuestStep1RequirementGainTechs);
$FirstQuestStep1RequirementGainTechs->setGainType('techs');
$FirstQuestStep1RequirementGainFuel->setGainType('fuel');
$FirstQuestStep1RequirementGainTechs->save();
$FirstQuestStep1RequirementGainFuel->save();


$ModuleQuest = new Quest();
$ModuleQuest->setName('Le roi du boost');
$ModuleQuest->setIntro('Améliorez votre vaisseau pour gagner bien plus que de la vitesse !');
$ModuleQuest->setDescription('En construisant et activant trois modules, obtenez deux emplacements supplémentaires pour ajouter des modules.');
$ModuleQuest->setQuestType('modules');
$ModuleQuest->save();

$ModuleQuestStep1 = new QuestStep();
$ModuleQuestStep1->setQuestId($ModuleQuest->getId());

$ModuleQuestStep2 = clone($ModuleQuestStep1);
$ModuleQuestStep3 = clone($ModuleQuestStep1);

$ModuleQuestStep1->setStepDescription('Fabriquez et activez le module "Bloc de soute"');
$ModuleQuestStep1->setStepName('Bloc de soute');
$ModuleQuestStep1->setStepNb(1);
$ModuleQuestStep1->save();

$ModuleQuestStep2->setStepDescription('Fabriquez et activez le module "Boost du réacteur"');
$ModuleQuestStep2->setStepName('Boost du réacteur');
$ModuleQuestStep2->setStepNb(2);
$ModuleQuestStep2->save();

$ModuleQuestStep3->setStepDescription('Fabriquez et activez le module "Batteries supplémentaires"');
$ModuleQuestStep3->setStepName('Batteries supplémentaires');
$ModuleQuestStep3->setStepNb(3);
$ModuleQuestStep3->save();

$ModuleQuestStep1Requirement = new QuestRequirement();
$ModuleQuestStep1Requirement->setQuestId($ModuleQuest->getId());
$ModuleQuestStep1Requirement->setRequirementQuantity(1);
$ModuleQuestStep1Requirement->setRequirementType('module_enabled');

$ModuleQuestStep2Requirement = clone($ModuleQuestStep1Requirement);
$ModuleQuestStep3Requirement = clone($ModuleQuestStep1Requirement);

$ModuleQuestStep1Requirement->setRequirementValue(1);
$ModuleQuestStep1Requirement->setRequirementQuantity(1);
$ModuleQuestStep1Requirement->setStepId($ModuleQuestStep1->getId());
$ModuleQuestStep1Requirement->save();

$ModuleQuestStep2Requirement->setRequirementValue(4);
$ModuleQuestStep2Requirement->setStepId($ModuleQuestStep2->getId());
$ModuleQuestStep2Requirement->save();

$ModuleQuestStep3Requirement->setRequirementValue(3);
$ModuleQuestStep3Requirement->setStepId($ModuleQuestStep3->getId());
$ModuleQuestStep3Requirement->save();

$ModuleQuestRequirementGainModule = new QuestGain();
$ModuleQuestRequirementGainModule->setQuestId($ModuleQuest->getId());
$ModuleQuestRequirementGainModule->setGainOperation('obtain');
$ModuleQuestRequirementGainModule->setGainType('module');
$ModuleQuestRequirementGainModule->setGainValue(7);
$ModuleQuestRequirementGainModule->setGainQuantity(1);
$ModuleQuestRequirementGainModule->save();

