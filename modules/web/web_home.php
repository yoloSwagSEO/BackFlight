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
            <strong>2442, somewhere in the space...</strong> Spaceships return to life after their captains wake up from cryogenic sleep. Smart crews awake from different places, and all of them seems to be survivors of a biggest ship, now disappeard. In their possession, only some flight documents and... a mysterious encrypted map that lead to a very powerful traveling network.
        </p>
        <p>
            You're one of this captains. Your mission ? Be the first crew to bring the map on Earth, or the first team to bring it to humanity. Choice is yours.
        </p>
        <p>
        With technologics fragments, energy residues, patience and strategy, you have to survive in that complexe environnment.
        </p>
        <p>
        More is to come...
        </p>
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
        <h4>Dates</h4>
        <span class="small success button">First alpha : 10/18</span>
        <span class="small success button">First closed beta : november</span>
        <span class="small success button">First open beta : december</span>
        <span class="small success button">Game launch : 2014</span>
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
<div class="row">
    <div class="large-9 columns">
        <a class="th radius" href="img/ui/sample.jpg" style="width: 200px; height: 150px;" target="_blank">
            <img src="img/ui/sample-th.jpg" />
        </a>
    </div>
</div>
<?php
foot();