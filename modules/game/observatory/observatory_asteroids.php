        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="search" class="button">Sonder les astéroïdes</a>
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
            <li data-tooltip title="Recherche rapide d'objet ou de ressources dans le champs d'astéroïdes.<br />Fin : <?php echo countDown($MasterShipPlayer->getSearchTime('search', 'asteroids'))?><br />Proba : <?php echo $MasterShipPosition->getSearchRealProbability('search', 'fuel', 'asteroids') * 100?>% (F) / <?php echo $MasterShipPosition->getSearchRealProbability('search', 'techs', 'asteroids') * 100?>% (T)"><a href="search/fast" >Sonder depuis le vaisseau</a></li>
            <?php
            }
            ?>
            <li data-tooltip title="Les deux sondes du vaisseau partent à la recherches d'objet ou de ressoources dans le champs d'astéroïdes. <br />Retour : <?php echo countDown($MasterShipPlayer->getSearchTime('probes', 'asteroids'))?><br />Proba : <?php echo $MasterShipPosition->getSearchRealProbability('probes', 'fuel', 'asteroids') * 100?>% (F) / <?php echo $MasterShipPosition->getSearchRealProbability('probes', 'techs', 'asteroids') * 100?>% (T)"><a href="search/probes">Larguer les sondes</a></li>
        </ul>
        <?php
        include_once 'modules/game/observatory/observatory_continue.php';
        ?>