<?php
title('Cargaison');
$array_modules = Module::getAll('', '', $User->getId());
$array_objects = Object::getAll('', '', $User->getId());

$array_weapons = $MasterShipPlayer->getObjects('weapons');
$array_weapons_user = array();
foreach ($array_weapons as $objectId => $quantity)
{
    $ObjectWeapon = $array_objects[$objectId];
    $array_weapons_user[$ObjectWeapon->getObjectType()][$objectId] = $quantity;
}


$fuel = $MasterShipPlayer->getFuel();
$techs = $MasterShipPlayer->getTechs();
$modules = $MasterShipPlayer->getModules();

$weight_fuel = $fuel * FUEL_WEIGHT;
$ratio_fuel = $weight_fuel / $MasterShipPlayer->getLoadMax() * 100;

$weight_techs = $techs * TECHS_WEIGHT;
$ratio_techs = $weight_techs / $MasterShipPlayer->getLoadMax() * 100;

$weight_modules = $MasterShipPlayer->getModulesWeight();
$ratio_modules = $weight_modules / $MasterShipPlayer->getLoadMax() * 100;

$weight_weapons = $MasterShipPlayer->getObjectsWeight('weapons');
$ratio_weapons = $weight_weapons / $MasterShipPlayer->getLoadMax() * 100;

$weight_remaining = 100 - $ratio_fuel - $ratio_techs - $ratio_modules - $ratio_weapons;


function dropForm ($ddid,$type, $max, $id=null,$subtype=null) {
// Print the link and form to drop ressources/objects/weapons
    echo '<a href="#" style="margin:5px" data-dropdown="'.$ddid.'" class="button tiny" data-tooltip title="Drop '.$type.'">';
    echo '<span class="icomoon" data-icon="&#xe0a8;" style="margin: 0 5px"></span></a>';
    echo '<div id="'.$ddid.'" class="f-dropdown" data-dropdown-content>
        <form action="cargo/drop" method="post">
        <div class="row collapse"><div class="large-8 columns">';
    if ($id != null) {
        echo '<input type="hidden" name="id" value="'.$id.'"/>';
    }
    if ($subtype != null) {
        echo '<input type="hidden" name="subtype" value="'.$subtype.'"/>';
    }
    echo '<input type="hidden" name="type" value="'.$type.'"/>';
    echo '<input type="number" name="quantity" min="0" max="'.$max.'" placeholder="max '.$max.'"/>';
    echo '</div>';
    echo '<div class="large-4 columns">';
    echo '<input type="submit" class="button postfix" value="Drop"/>';
    echo '</div></div></form>';
    echo '</div>';
}

head();
?>

<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <?php
        // Display when you drop fuel/techs
        if (isset($_SESSION['infos']['drop'])) {
        ?>
        <div data-alert class="alert-box success radius"><span class="icomoon" data-icon="&#xe0a8;" style="margin: 0 5px"></span>Larguage de <?php echo $_SESSION['infos']['drop']['quantity'].' '.$_SESSION['infos']['drop']['type'] ?> avec succès !</div>
        <?php
            unset($_SESSION['infos']['drop']);
        } ?>
        
        <h3>Cargaison</h3>

        Répartition de la cargaison :
        <div class="progress">
            <span class="meter alert" style="width: <?php echo $ratio_fuel?>%" title="Fuel : <?php echo $weight_fuel?>" data-tooltip></span>
            <span class="meter" style="width: <?php echo $ratio_techs?>%" title="Techs : <?php echo $weight_techs?>" data-tooltip></span>
            <span class="meter success" style="width: <?php echo $ratio_modules?>%" title="Modules : <?php echo $weight_modules?>" data-tooltip></span>
            <span class="meter" style="width: <?php echo $ratio_weapons?>%" title="Weapons : <?php echo $weight_weapons?>" data-tooltip></span>
            <span style="height: 100%; display: inline-block; width: <?php echo $weight_remaining?>%" title="Remaining : <?php echo $weight_remaining?>" data-tooltip></span>
        </div>

        <div class="panel">
            <h4>Ressources <small>(<?php echo $weight_fuel + $weight_techs?>)</small></h4>
            <div>
                <?php dropForm('dropfuel','fuel', $fuel); ?>
                <?php echo $fuel .' fuel <small>('.FUEL_WEIGHT.')</small> : '.$weight_fuel ;?>
            </div>
            
            <div>
                <?php dropForm('droptechs','techs', $techs); ?>
                <?php echo $techs .' techs <small>('.TECHS_WEIGHT.')</small> : '. $weight_techs ;?>
            </div>
        </div>
        
        <?php if (!empty($modules)) { ?>
        <div class="panel modules">
            <h4>Modules <small>(<?php echo $weight_modules?>)</small></h4>
            <?php
            foreach ($modules as $moduleId => $quantity)
            {
                ?>
            <div class="row">
                <div class="large-12 columns">
                    <?php
                if ($quantity != 0) {
                    $Module = $array_modules[$moduleId];
                    dropForm('dropmodule'.$Module->getId(),'module',$quantity, $Module->getId());
                    echo $quantity .' '. $Module->getName() .' <small>('.$Module->getWeight().')</small> : '.$Module->getWeight()*$quantity;
                }
                ?>
                </div>
            </div>
                    <?php
            }
            ?>
        </div>
        <?php } ?>

        <?php if (!empty($array_weapons_user)) { ?>
        <div class="panel armes">
            <h4>Armes <small>(<?php echo $weight_weapons?>)</small></h4>
            <?php
        foreach ($array_weapons_user as $type => $array_weapons_type)
        {
            foreach ($array_weapons_type as $objectId => $quantity)
            {
                ?>
            <div class="row">
                <div class="large-12 columns">
                <?php
                if ($quantity != 0) {
                    dropForm('dropweapon'.$ObjectWeapon->getId(),'weapon', $quantity, $ObjectWeapon->getId(),$type);
                    echo $quantity.' '.$ObjectWeapon->getObjectName(). ' <small>('.$ObjectWeapon->getObjectWeight().')</small> : '.$ObjectWeapon->getObjectWeight()*$quantity; ?>
                <?php
                }
                ?>
                </div>
            </div>
                <?php
            }
            ?>
            </div>
            <?php
        }
            ?>
        </div>
        <?php } ?>

    </div>
</div>

<?php
foot();
