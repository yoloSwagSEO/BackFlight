<?php 
// If there is no quest, we have to create quests, steps, requirements and gains
$FirstQuest = new Quest();
$FirstQuest->setName('A la recherche des techs perdues');
$FirstQuest->setIntro('Qui cherche des techs récolte des techs !');
$FirstQuest->setDescription('Effectuez trois recherches réussies et doublez vos gains !');
$FirstQuest->setPositionId(Position::getClearPosition()->getId());
$FirstQuest->setQuestType('resources');
$FirstQuest->save();

$FirstQuestStep1 = new QuestStep();
$FirstQuestStep1->setQuestId($FirstQuest->getId());
$FirstQuestStep1->setStepDescription('Effectuer trois recherches réussies');
$FirstQuestStep1->setStepName('Trois recherches');
$FirstQuestStep1->setStepNb(1);
$FirstQuestStep1->save();

$FirstQuestStep1Requirement = new QuestRequirement();
$FirstQuestStep1Requirement->setQuestId($FirstQuest->getId());
$FirstQuestStep1Requirement->setStepId($FirstQuestStep1->getId());
$FirstQuestStep1Requirement->setRequirementType('searches');
$FirstQuestStep1Requirement->setRequirementQuantity(3);
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

