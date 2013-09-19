        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="go-to" class="button">Se diriger vers la planète</a>
            <a href="#" data-dropdown="continue" class="button">Poursuivre le vol</a>
            <a href="#" data-dropdown="reach" class="button">Atteindre une position connue</a>
        </div>
    </div>
</div>
<ul id="go-to" class="f-dropdown" data-dropdown-content>
  <li data-tooltip class="has-tip" title="Les activités sur la planète ne seront pas détectées.<br />Arrivée : 1m<br />"><a href="fly/planet/fast" >Approche rapide</a></li>
  <li data-tooltip class="has-tip" title="Les activités et ressources seront scannées rapidement. <br />Arrivée : 4m"><a href="fly/planet">Approche normale</a></li>
</ul>
<?php
include_once 'modules/game/observatory/observatory_continue.php';
?>