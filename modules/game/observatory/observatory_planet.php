        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="search" class="button">Explorer la planète</a>
            <?php
            if (!$MasterShipPlayer->isShipDamaged()) {
            ?>
            <a href="#" data-dropdown="continue" class="button">Poursuivre le vol</a>
            <a href="#" data-dropdown="reach" class="button">Atteindre une position connue</a>
            <?php
            }
            ?>
        </div>
        <ul id="search" class="f-dropdown" data-dropdown-content>
            <?php
            if (!$MasterShipPlayer->isShipDamaged()) {
            ?>
            <li data-tooltip title="Détecte la présence de vie et peut obtenir des ressources.<br />Fin : <?php echo countDown($MasterShipPlayer->getSearchTime('search', 'planet'))?><br />Proba : <?php echo $MasterShipPosition->getSearchRealProbability('search', 'fuel', 'planet') * 100?>% (F) / <?php echo $MasterShipPosition->getSearchRealProbability('search', 'techs', 'planet') * 100?>% (T)"><a href="search/fast" >Vol d'approche de la planète</a></li>
            <?php
            }
            ?>
            <li data-tooltip title="En déployant les sondes sur la planète, vous augmentez la probabilité de trouver des ressource. <br />Détecte les formes de vie. <br />Retour : <?php echo countDown($MasterShipPlayer->getSearchTime('probes', 'planet'))?><br />Proba : <?php echo $MasterShipPosition->getSearchRealProbability('probes', 'fuel', 'planet') * 100?>% (F) / <?php echo $MasterShipPosition->getSearchRealProbability('probes', 'techs', 'planet') * 100?>% (T)"><a href="search/probes">Larguer les sondes</a></li>
        </ul>



        <?php
        include_once 'modules/game/observatory/observatory_continue.php';
        ?>