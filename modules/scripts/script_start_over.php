<?php
title('Remise à zéro du jeu');

head();

$sql = FlyPDO::get();
$req = $sql->prepare('SHOW TABLE STATUS FROM `backflight`;');

$rows = array();
if ($req->execute()) {

}
while ($row = $req->fetch()) {
    $rows[] = $row;
}

$n = 0;
foreach ($rows as $row) {
    $req = $sql->prepare('TRUNCATE TABLE `' . mysql_real_escape_string($row['Name']) . '`;');
    if ($req->execute()) {
        ++$n;
    } else {
        var_dump($req->errorInfo());
    }
}

?>
<div class="row">
    <div class="large-12 columns">
        
<?php echo $n . ' tables dropped'; ?>
    </div>
</div>

<?php
foot();

?>
