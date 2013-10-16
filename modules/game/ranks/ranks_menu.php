<?php
$type = 'global';
if (!empty($_GET['type'])) {
    $type = $_GET['type'];
}
?>
<dl class="sub-nav">
    <dt>Classement : </dt>
    <dd<?php if ($type == 'global') {?> class="active"<?php } ?>><a href="ranks">Général</a></dd>
    <dd<?php if ($type == 'position') {?> class="active"<?php } ?>><a href="ranks/position">Position</a></dd>
    <dd<?php if ($type == 'ressources') {?> class="active"<?php } ?>><a href="ranks/ressources">Ressources</a></dd>
    <dd<?php if ($type == 'distance') {?> class="active"<?php } ?>><a href="ranks/distance">Distance</a></dd>
</dl>