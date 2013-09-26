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

$MasterShipModel = new Model();
$MasterShipModel->setName('Survivor');
$MasterShipModel->setCategory('master');
$MasterShipModel->setLoadMax(SHIP_START_LOADMAX);
$MasterShipModel->setEnergyMax(SHIP_START_ENERGYMAX);
$MasterShipModel->setEnergyGain(SHIP_START_ENERGY_GAIN);
$MasterShipModel->setFuelMax(SHIP_START_FUELMAX);
$MasterShipModel->setPowerMax(SHIP_START_POWERMAX);
$MasterShipModel->setSpeed(SHIP_START_SPEED);

$MasterShipModel->save();


$User = new User();
$pseudo_ok = $User->setPseudo('Player');
$mail_ok = $User->setMail('player@backflight.fr');
$User->setPassword('Fly, you fools!');

if ($pseudo_ok == true && $mail_ok === true) {
    $User->save();
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
