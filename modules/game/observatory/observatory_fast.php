<?php
title('Observatory - Fast look');
head();


?>
<div class="row">
    <div class="column large-3">
        <ul class="side-nav">
            <li><a href="overview">Ma position</a></li>
        </ul>
    </div>
    <div class="column large-9">
        <h3>Observatoire</h3>
        <div data-alert class="alert-box success radius">
            Les outils détectent une planète habitable. 
            <a href="observatory" class="close">&times;</a>
        </div>

        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="go-to" class="button">Se diriger vers la planète</a>
            <a href="#" data-dropdown="continue" class="button">Poursuivre la trajectoire</a>
        </div>
    </div>
</div>
<ul id="go-to" class="f-dropdown" data-dropdown-content>
  <li data-tooltip class="has-tip" title="Les activités sur la planète ne seront pas détectées.<br />Arrivée : 1m<br />"><a href="fly/planet/fast" >Approche rapide</a></li>
  <li data-tooltip class="has-tip" title="Les activités et ressources seront scannées rapidement. <br />Arrivée : 4m"><a href="fly/planet">Approche normale</a></li>
</ul>
<ul id="continue" class="f-dropdown" data-dropdown-content>
  <li data-tooltip class="has-tip" title="Déplacement ultra-rapide vers une autre zone de l'espace.<br />Prochain bond : 30s<br />"><a href="fly/space/fast">Bond hyperespace</a></li>
  <li data-tooltip class="has-tip" title="Déplacement vers une autre zone de l'espace. <br />Arrivée : 6m"><a href="fly/space">Vol hyperespace</a></li>
</ul>



<?php
foot();
?>

