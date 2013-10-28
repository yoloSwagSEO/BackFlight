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

function dropForm ($ddid,$type,$id=null,$subtype=null) {
// Print the link and form to drop ressources/objects/weapons
    echo '<a href="#" style="margin:5px" data-dropdown="'.$ddid.'" class="button tiny">';
    echo '<span class="icomoon" data-icon="&#xe0a8;" style="margin: 0 5px"></span></a>';
    echo '<form id="'.$ddid.'" class="f-dropdown" action="cargo/drop" method="post" data-dropdown-content>';
    if ($id != null) {
        echo '<input type="hidden" name="id" value="'.$id.'"/>';
    }
    if ($subtype != null) {
        echo '<input type="hidden" name="subtype" value="'.$subtype.'"/>';
    }
    echo '<input type="hidden" name="type" value="'.$type.'"/>';
    echo '<input type="number" name="quantity" min="0"/><input type="submit" class="button tiny"/></form>';
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


        <div><?php dropForm('dropfuel','fuel'); ?>Fuel : <?php echo $fuel .' * '. FUEL_WEIGHT .' = '.$fuel * FUEL_WEIGHT ;?>
        </div>
        
        <div><?php dropForm('droptechs','techs'); ?>Techs : <?php echo $techs .' * '. TECHS_WEIGHT .' = '.$techs * TECHS_WEIGHT ;?>
        </div>

        <div class="panel modules">
            <h4>Modules</h4>
            <div class="row">
            <?php
            foreach ($modules as $moduleId => $quantity)
            {
                if ($quantity != 0) {
                    $Module = $array_modules[$moduleId];
                    dropForm('dropmodule'.$Module->getId(),'module',$Module->getId());
                    echo $quantity .' '. $Module->getName();
                }
            }
            ?>
            </div>
        </div>
        
        <div class="panel armes">
            <?php
        foreach ($array_weapons_user as $type => $array_weapons_type)
        {
            if (!empty($array_weapons_type)) {
                ?>
                <h4><?php echo $type ?></h4>
                <div class="row">
                <?php
                foreach ($array_weapons_type as $objectId => $quantity)
                {
                    if ($quantity != 0) {
                        dropForm('dropweapon'.$ObjectWeapon->getId(),'weapon',$ObjectWeapon->getId(),$type);
                        echo $quantity.' '.$ObjectWeapon->getObjectName(); ?>
                    <?php
                    }
                }
                ?>
                </div>
                <?php
            }
        }
            ?>
        </div>

    </div>
</div>

<?php
foot();
