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
if ($type == 'fuel') {
    $max = number_format($MasterShipPlayer->getFuel());
} else if ($type == 'techs') {
    $max = number_format($MasterShipPlayer->getTechs());
}

// If quantity < 0, quantity = 0
// If quantity > max, quantity = max
$quantity = max(min($max,$quantity),0);

// Save type and quantity for notification
if ($type == 'fuel') {
    $MasterShipPlayer->removeFuel($quantity);
    $_SESSION['infos']['drop']['type'] = 'fuel';
} else if ($type == 'techs') {
    $MasterShipPlayer->removeTechs($quantity);
    $_SESSION['infos']['drop']['techs'] = 'tech'. ($quantity>1?'s':'');
}
$_SESSION['infos']['drop'][$type]['quantity'] = $quantity;


// Drop ressources and save
$MasterShipPlayer->save();

// Exit.
header('location: '.PATH.'ship');
exit;
