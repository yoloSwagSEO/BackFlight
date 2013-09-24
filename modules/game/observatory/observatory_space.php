        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="search" class="button">Sonder l'espace</a>
            <a href="#" data-dropdown="continue" class="button">Poursuivre le vol</a>
            <a href="#" data-dropdown="reach" class="button">Atteindre une position connue</a>
        </div>
    </div>
</div>
<ul id="search" class="f-dropdown" data-dropdown-content>
    <li data-tooltip class="has-tip" title="Recherche rapide d'objet ou de ressources dans l'espace.<br />Fin : 30s<br />Proba : 20%"><a href="search/fast" >Sonder depuis le vaisseau</a></li>
    <li data-tooltip class="has-tip" title="Les deux sondes du vaisseau partent à la recherches d'objet ou de ressoources dans l'espace. <br />Retour : 4m15<br />Proba : 100%"><a href="search/probes">Larguer les sondes</a></li>
</ul>
<?php
include_once 'modules/game/observatory/observatory_continue.php';
?>