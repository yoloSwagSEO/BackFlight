<?php
title('BackFlight - A simple game in a complex space');
head();
?>
<div class="row">
    <?php
    if (!empty($_SESSION['infos']['inscription'])) {
        ?>
        <div data-alert="" class="alert-box success radius">Votre inscription a été effectuée. Vous pouvez maintenant vous connecter et jouer !</div>
        <?php
        unset($_SESSION['infos']['inscription']);
    }
    ?>
    <div class="large-9 columns">
        <div class="panel">A simple game in a complex space</div>
        <p>
            <strong>2442, quelque part dans l'espace...</strong> <br />
            Un à un, des vaisseaux se réveillent après le long sommeil cryogénique de leurs capitaines. <br />
Tous leurs équipages semblent se souvenir d'une seule chose : ils faisaient partie de la plus grande mission d'exploration jamais réalisée, à bord d'un plus grand vaisseau.<br />
En leur possession : quelques documents de vol et... une mystérieuse carte cryptée qui ouvre l'accès à des voies de communication intergalactiques.
        </p>
        <p>
Vous êtes un de ces capitaines. Votre mission ? Être le premier équipage à ramener la carte sur terre, ou la première équipe à l'offrir à l'humanité. 
        </p>
        <p>
Grâce à des débris technologiques, des restes de carburant, de la patience et de la stratégie, vous aurez à survivre dans cette course à la terre. <br />
Serez-vous prêt à relevez le défi ?
        </p>

        <div class="row">
            <a class="th radius" href="img/ui/sample.jpg" style="width: 200px; height: 150px;" target="_blank">
                <img src="img/ui/sample-th.jpg" />
            </a>
        </div>
    </div>
    <div class="large-3 columns">
        <div class="panel">
            <h4>Connexion</h4>
            <?php
            if (!empty($_SESSION['error_connexion'])) {
                ?>
                <div data-alert="" class="alert-box alert radius">Erreur lors de la connexion : pseudo et mot de passe invalides ou joueur inexistant.</div>
                <?php
            }
            ?>
            <form action="connexion" method="post">
                <div class="row collapse">
                    <div class="small-2 columns">
                      <span class="prefix radius" data-icon="&#xe09f;"></span>
                    </div>
                    <div class="small-10 columns">
                      <input type="text" placeholder="Joueur" name="pseudo">
                    </div>
                  </div>
                <div class="row collapse">
                    <div class="small-2 columns">
                      <span class="prefix radius" data-icon="&#xe2b1;"></span>
                    </div>
                    <div class="small-10 columns">
                      <input type="password" placeholder="Mot de passe" name="password">
                    </div>
                </div>
                <input type="submit" class="button small radius" style="width: 100%" value="Connexion" />
                <a href="inscription">Inscription</a>
            </form>
        </div>
        <div class='panel callout'>
            <strong style='color: white'>Alpha 0.1.1</strong>
            <p style="font-size: .9em">
                - <a href="https://github.com/In4matik/BackFlight/pull/2">#2</a> Fix unread messages<br />
                - <a href="https://github.com/In4matik/BackFlight/pull/6">#6</a> Fix module description<br />
                - Add page generation time<br />
                - More techs on game start<br />
                - Add game speed value<br />
            </p>
        </div>
        <?php
        if (ENABLE_SCRIPTS) {
            ?>
            <h4>Scripts</h4>
            <a href="scripts/create-player"><span class="small button">Create player</span></a>
            <a href="scripts/start-over"><span class="small button">Start over</span></a>
            <?php

        }
        ?>        
    </div>

</div>

<?php
foot();