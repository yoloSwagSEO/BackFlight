<?php
title('Quest');
head();

$Quest = new Quest($_GET['questId'], $User->getId());
if (!$Quest->isSql()) {
    exit('Unknown quest !');
}
?>
<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/ship/ship_details.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Quête : <?php echo $Quest->getName()?></h3>
        <h4><?php echo $Quest->getIntro()?></h4>
        <?php
        if ($Quest->isStartedByPlayer()) {
            ?>
            <div data-alert class="alert-box radius">
                Vous avez commencé cette quête.
            </div>
            <?php
        }
        ?>
        <p>
            <?php echo $Quest->getDescription()?>
        </p>
        <ul class="ul_blocs">
            <?php
            foreach ($Quest->getSteps() as $QuestStep)
            {
                $requirements = $QuestStep->getStepRequirements();
                ?>
            <li><strong><?php echo $QuestStep->getStepName()?></strong>
                <br /><?php echo $QuestStep->getStepDescription()?>
                <?php
                if ($requirements) {
                    ?>
                <?php
                foreach ($requirements as $QuestRequirement)
                {
                    $add = '';
                    if ($QuestRequirement->isDone()) {
                        $add = '[OK] ';
                    }
                    ?>
                <hr />
                <strong><?php echo $add.$QuestRequirement->getRequirementType()?></strong> : <?php echo $QuestRequirement->getRequirementValueUser()?>/<?php echo $QuestRequirement->getRequirementValue()?>
                    <br />
                    <?php
                }
                ?>
                    <?php
                }

                ?>
                <?php
                if ($QuestStep->getStepGains()) {
                ?>
                <br /><i>
                    Gains :
                    <?php
                    foreach ($QuestStep->getStepGains() as $type => $gain)
                    {
                        echo '<kbd>';
                        if ($gain['operation'] == 'multiply') {
                            echo $type.' x'.$gain['quantity'];
                        } else {
                            echo ' +'.$gain['quantity'].$type;
                        }
                        echo '</kbd>';
                    }
                    ?>
                
                    </i>
                <?php
                } else {
                    ?>
                    
                    <?php
                }
                ?>
            </li>
                <?php
            }
            ?>
        </ul>
        <?php
        if ($Quest->getGains()) {
        ?>
        <p>
            Gains : <br />
            <?php
            foreach ($Quest->getGains() as $type => $gain)
            {
                echo '<kbd>';
                if ($gain['operation'] == 'multiply') {
                    echo $type.' x'.$gain['quantity'];
                } else {
                    echo ' +'.$gain['quantity'].' '.$type;
                }
                echo '</kbd>';
            }
            ?>
        </p>
        <?php
        }
        if (!$Quest->isStartedByPlayer()) {
        ?>
        <form action="" method="post">
            <input type="submit" class="button" value="Commencer cette mission" name="quest_start" />
        </form>
        <?php
        }
        ?>
    </div>
</div>
<?php
foot();
