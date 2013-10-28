<?php
// Sanitize the quantity input
$quantity = preg_replace("[^0-9]", "", $_POST['quantity']);

// Wrong type input, exit
$type = $_GET['type'];
$types = array ('fuel', 'techs');
if (!in_array($type, $types)) {
    exit('You can only drop techs and fuel !');
}

// Define max value
if ($type == 'techs') {
    $max = number_format($MasterShipPlayer->getTechs());
} else {
    $max = number_format($MasterShipPlayer->getFuel());
}

// If quantity < 0, quantity = 0
// If quantity > max, quantity = max
$quantity = max(min($max,$quantity),0);

if ($type == 'fuel') {
    $MasterShipPlayer->removeFuel($quantity);
    $_SESSION['infos']['drop']['fuel'] = $quantity;
} else {
    $MasterShipPlayer->removeTechs($quantity);
    $_SESSION['infos']['drop']['techs'] = $quantity;
}
// Drop ressources and save
$MasterShipPlayer->save();

// Exit.
header('location: '.PATH.'ship');
exit;
