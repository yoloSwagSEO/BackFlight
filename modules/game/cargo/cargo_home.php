<?php
title('Cargaison');
head();
?>

<div class="row">
    <div class="column large-3">
        <?php include_once 'includes/menu.php';?>
        <?php include_once 'modules/game/earth/earth_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Cargaison</h3>
        <?php
        // Display when you drop fuel/techs
        if (isset($_SESSION['infos']['drop'])) {
            foreach ($_SESSION['infos']['drop'] as $object) {
        ?>
        <span class="icomoon" data-icon="&#xe0a8;" style="margin: 0 5px"></span><div data-alert class="alert-box success radius">Larguage de <?php echo $object['quantity'].' '.$object['type'] ?> avec succès !</div>
        <?php
            }
            unset($_SESSION['infos']['drop']);
        }
        ?>
    <?php
    // TODO : Affichage de la cargaison
    ?>
    
    </div>
</div>

<?php
foot();
