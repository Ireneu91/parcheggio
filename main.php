<?php

require_once 'Parking.php';
require_once 'ParkingFloor.php';

$floor1 = new ParkingFloor(50);
$floor2 = new ParkingFloor(30);
$floor3 = new ParkingFloor(10);

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

/*
echo "\n".$parking->cars_count();        // 0
echo "\n".$parking->capacity_count();    // 90

echo "\n".$parking->park_cars(65);       // 0 (tutte entrano, dall'alto verso il basso)

echo "\n";
var_dump($parking->cars_distribution()); // [50,15,0]

echo "\n".$parking->park_cars(50);       // 25 auto avanzano
echo "\n";

var_dump($parking->cars_distribution()); // [50,30,10]



echo "\n".$parking->leave_cars(15);      // rimuove a partire dal basso

var_dump($parking->cars_distribution()); // [50,25,0]
echo "\n".$parking->cars_count();        // 75
*/

//------------------------------------------

echo "\n".$floor1->cars_count();         // 0 posti occupati


$floor1->add_reservation();    // uno dei posti del piano è riservato, non può essere usato

echo "\n".$floor1->reservation_count();  // 1

echo "\n".$floor1->cars_count();         // 1 posti occupati

echo "\n".$floor1->add_reservation();    // un nuovo posto del piano è riservato


echo "\n".$floor1->reservation_count();  // 2

$floor1->cars_count();         // 2 posti occupati

$floor1->park_cars(5);         //
echo "\n".$floor1->reservation_count();  // 2


echo "\n".$floor1->cars_count();         // 7 posti occupati
 
$floor1->remove_reservation(); // uno dei posti del piano non è più riservato, può essere nuovamente usato
echo "\n".$floor1->reservation_count();  // 1

echo "\n".$floor1->cars_count();         // 6 posti occupati

/*
$parking->add_reservation();   // uno dei posti del piano più in alto è riservato, solo se libero in questo momento altrimenti si va al piano successivo

$parking->close_floor($floor1); // il piano viene chiuso temporaneamente, non accetta nuove auto, tutte le auto attuali vengono spostate verso altri piani, a partire dall'alto
$parking->open_floor($floor1);  // il piano viene riaperto

$floor1->report();             // stampa report formattato con numero posti liberi, posti prenotati, posti liberi
$parking->report();            // stampa report formattato con numero posti liberi, posti prenotati, posti liberi

$parking->leave_cars(15, "bottom"); // rimuove a partire dal basso, nessun cambiamento
$parking->leave_cars(15, "top");    // rimuove a partire dall'alto
$parking->leave_cars(15, "random"); // rimuove random, in maniera pesata (ovvero è più probabile per i piani con più macchine)

*/