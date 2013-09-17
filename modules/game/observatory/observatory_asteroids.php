        <div>
            <p>Que souhaitez-vous faire ?</p>
            <a href="#" data-dropdown="land" class="button">Déployer le vaisseau sur un astéroïde</a>
            <a href="#" data-dropdown="continue" class="button">Poursuivre le vol</a>
        </div>
    </div>
</div>
<ul id="land" class="f-dropdown" data-dropdown-content>
  <li data-tooltip class="has-tip" title="Le vaisseau tentera de se poser sur l'astéroïde le plus proche.<br />Arrivée : 30s<br />"><a href="fly/asteroid/fast" >Déploiement rapide</a></li>
  <li data-tooltip class="has-tip" title="Après une phase d'observation, le vaisseau tentera de se poser sur l'astéroïde le plus adapté. <br />Arrivée : 3m"><a href="fly/asteroid">Observation et déploiement</a></li>
</ul>
<ul id="continue" class="f-dropdown" data-dropdown-content>
  <li data-tooltip class="has-tip" title="Déplacement ultra-rapide vers une autre zone de l'espace.<br />Prochain bond : 30s<br />Energie : 20"><a href="fly/space/fast">Bond hyperespace</a></li>
  <li data-tooltip class="has-tip" title="Déplacement vers une autre zone de l'espace. <br />Arrivée : 6m<br />Energie : 5"><a href="fly/space">Vol hyperespace</a></li>
</ul>