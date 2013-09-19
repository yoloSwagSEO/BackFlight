        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="land" class="button">Déployer le vaisseau sur un astéroïde</a>
            <a href="#" data-dropdown="continue" class="button">Poursuivre le vol</a>
            <a href="#" data-dropdown="reach" class="button">Atteindre une position connue</a>
        </div>
    </div>
</div>
<ul id="land" class="f-dropdown" data-dropdown-content>
  <li data-tooltip class="has-tip" title="Le vaisseau tentera de se poser sur l'astéroïde le plus proche.<br />Arrivée : 30s<br />"><a href="fly/asteroid/fast" >Déploiement rapide</a></li>
  <li data-tooltip class="has-tip" title="Après une phase d'observation, le vaisseau tentera de se poser sur l'astéroïde le plus adapté. <br />Arrivée : 3m"><a href="fly/asteroid">Observation et déploiement</a></li>
</ul>
<?php
include_once 'modules/game/observatory/observatory_continue.php';
?>