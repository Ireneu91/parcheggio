<?php

require_once 'Parking.php';
require_once 'ParkingFloor.php';

$floor1 = new ParkingFloor(50);
$floor2 = new ParkingFloor(50);
$floor3 = new ParkingFloor(50);

/*
$floor1->cars_count();         // 0
$floor1->capacity_count();     // 50
$floor1->park_cars(5);         // 0 (tutte entrano)

$floor1->park_cars(55);        // 10 (10 non riescono ad entrare)

$floor1->cars_count();         // 50

echo "\n".$floor1->leave_cars(10);       // 0 (il numero di auto che non riesce a togliere, riesce a toglierle tutte)


echo "\n".$floor1->cars_count();         // 40
echo "\n".$floor1->leave_cars(50);       // 10 (solo 40 vengono tolte, restituisce il valore che avanza)
echo "\n".$floor1->cars_count();         // 0
*/

$parking = new Parking();
$parking->add_floor($floor1);
$parking->add_floor($floor2);
$parking->add_floor($floor3);

$floor1->park_cars(5);
$floor2->park_cars(46);
$floor3->park_cars(7);

$floor2->add_reservation();
$floor2->add_reservation();
//$floor3->add_reservation();


$parking->close_floor($floor2);
var_dump($parking);

$parking->open_floor($floor2);

var_dump($parking);
$floor2->add_reservation();
$parking->park_cars(50);
var_dump($parking);
