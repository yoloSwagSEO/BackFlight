<?php
title('Observatory');
head();


?>
<div class="row">
    <div class="column large-3">
        <ul class="side-nav">
            <li><a href="overview">Ma position</a></li>
        </ul>
        <?php include_once 'modules/game/ship/ship_details.php';?>
    </div>
    <div class="column large-9">
        <h3>Observatoire</h3>
        <div data-alert class="alert-box success radius">
            Une lueur est visible dans le ciel...<br />
            <a href="observatory" class="close">&times;</a>
        </div>

        <div>
        <a href="#" data-dropdown="watch" class="button">Observer</a>
        </div>
    </div>
</div>
<ul id="watch" class="f-dropdown" data-dropdown-content>
  <li><a href="observatory/fast" data-tooltip class="has-tip" title="Détecte une planète proche de la base">Jeter un oeil</a></li>
</ul>

<?php
foot();
?>

