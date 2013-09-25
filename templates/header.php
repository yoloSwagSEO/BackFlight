<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <base href="http://localhost/BackFlight/" />
    <title><?php echo title()?></title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/foundation.css" />
<?php
    $array_styles = css();
    foreach ($array_styles as $src => $null)
    {
        echo '    <link rel="stylesheet" href="css/'.$src.'.css" />'."\n";
    }
    ?>
    <script src="js/vendor/custom.modernizr.js"></script>
</head>
<body>
    <div class="row">
        <div class="large-9 columns">
            <h1><a href="#">BackFlight</a></h1>
        </div>
        <div class="large-3 columns">
            <?php
            if (isConnected()) {
                echo 'Connecté en tant que '.$User->getPseudo().'<br /><a href="connexion/out">Déconnexion</a>';
            } else {
                echo '<a href="connexion">Connexion</a>';
            }
            ?>
        </div>
        <hr />
    </div>
    <?php
    if ($User->isConnected()) {
        if (!empty($array_moves)) {
            foreach ($array_moves as $Move)
            {
        ?>
    <div class="row">
        <div data-alert="" class="alert-box radius">
            <strong>Flotte de <?php echo $User->getPseudo()?></strong> (<?php echo $Move->getType()?>) en provenance de <?php echo $Move->getFrom()?> et à destination de <?php echo $Move->getTo() ?> (<?php echo renderCountDown($Move->countRemainingTime())?>)
        </div>
    </div>
        <?php
            }
        }

        // Searches
        if (!empty($_SESSION['infos']['search'])) {
            if ($_SESSION['infos']['search'] == 'empty') {
                ?>

    <div class="row">
        <div data-alert="" class="alert-box radius">
            Malgré des scans intensifs, rien n'a été trouvé au cours de la recherche.
        </div>
    </div>
    <?php
            } else {
                ?>
    <div class="row">
        <div data-alert="" class="alert-box success radius">
            La recherche a été fructueuse : +<?php echo $_SESSION['infos']['search'][1]?> <?php echo $_SESSION['infos']['search'][0]?>
        </div>
    </div>
    <?php
            }
            unset($_SESSION['infos']['search']);
        }

        // Max fuel level
        if (!empty($_SESSION['errors']['fuel']['lost'])) {
            ?>

    <div class="row">
        <div data-alert="" class="alert-box alert radius">
            Par manque de place dans le réservoir, <?php echo $_SESSION['errors']['fuel']['lost'] ?> fuel a été abandonné dans l'espace. Songez à agrandir vos réserves.
        </div>
    </div>
    <?php
        unset($_SESSION['errors']['fuel']['lost']);
        }

        // Max techs quantiy
        if (!empty($_SESSION['errors']['techs']['lost'])) {
            ?>

    <div class="row">
        <div data-alert="" class="alert-box alert radius">
            Pour éviter une surcharge, <?php echo $_SESSION['errors']['techs']['lost'] ?> débris technologiques ont été abandonnés dans l'espace. Songez à agrandir votre capacité de chargement.
        </div>
    </div>
    <?php
        unset($_SESSION['errors']['techs']['lost']);
        }


    }
    ?>