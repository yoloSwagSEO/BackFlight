<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <base href="<?php echo PATH ?>" />
    <title><?php echo title()?></title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/game.css" />
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
            <p>
            <?php
            if (isConnected()) {
                echo $User->getPseudo().' - <a href="connexion/out">Déconnexion</a>';
            }
            ?>
            </p>
                <?php
                if (!empty($array_notifications_unread)) {
                    $nb = count($array_notifications_unread);
                    echo '<a href="notifications" class="tiny button alert">'.$nb.' notification(s)</a>';
                }
                ?>
        </div>
        <hr />
    </div>
    <?php
    if ($User->isConnected()) {
        if (!empty($array_actions)) {
            foreach ($array_actions as $Action)
            {
        ?>
    <div class="row">
        <div data-alert="" class="alert-box radius">
            <strong>Flotte de <?php echo $User->getPseudo()?></strong> (<?php echo $Action->getType()?>) en provenance de <?php echo $Action->getFromX()?>:<?php echo $Action->getFromY()?> et à destination de <?php echo $Action->getToX() ?>:<?php echo $Action->getToY()?> (<?php echo renderCountDown($Action->countRemainingTime())?>)
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

        if (!empty($_SESSION['infos']['flight']['damages'])) {
            ?>
    <div class="row">
        <div data-alert="" class="alert-box alert radius">
            Au cours du vol, le vaisseau a été pris dans un champ d'astéroïdes de petite taille et a perdu <?php echo $_SESSION['infos']['flight']['damages']?> power.
        </div>
    </div>
    <?php
            unset($_SESSION['infos']['flight']['damages']);

        }
        
        if (!empty($array_torpedoes_user)) {
            foreach ($array_torpedoes_user as $type => $torpedoes)
            {
                foreach ($torpedoes as $ObjectUser)
                {
                    $distance = Position::calculateDistance($ObjectUser->getObjectFromX(), $ObjectUser->getObjectFromY(), $ObjectUser->getPositionShipX(), $ObjectUser->getPositionShipY());
                    $time_travel = $distance / $ObjectUser->getObjectSpeed();
                    $time_remaining = $ObjectUser->getObjectStart() + $time_travel - time();

                    if ($type == 'target') {
                        ?>
                        <div class="row">
                            <div data-alert="" class="alert-box alert radius">
                                Attaque de torpille détectée depuis <?php echo $ObjectUser->getObjectFromX()?>:<?php echo $ObjectUser->getObjectFromY()?> (<?php echo $ObjectUser->getObjectUserpseudo()?>) ! Impact estimé dans <?php echo renderCountDown($time_remaining)?>.
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="row">
                            <div data-alert="" class="alert-box radius">
                                Attaque de torpille vers vaiseau de <?php echo $ObjectUser->getUserToPseudo()?> (<?php echo $ObjectUser->getPositionShipX()?>:<?php echo $ObjectUser->getPositionShipY()?>) ! Impact estimé dans <?php echo renderCountDown($time_remaining)?>.
                            </div>
                        </div>
                        <?php
                    }
                }                
            }
        }

    }
    ?>