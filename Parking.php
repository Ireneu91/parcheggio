<?php declare(strict_types=1);

class Parking{

    // proprietà: parcheggio composto da piani
    private array $floors;



    //----------- metodi -------------//

    // rende un piano, che è un oggetto di classe ParkingFloor
    public function add_floor(ParkingFloor $floor): void {
        $this->floors[] = $floor;
    }


    public function cars_count(): int {
        $totalCars = 0;
        foreach($this->floors as $floor) {
            $totalCars += $floor->cars_count(); // per ogni piano conto le macchine
        }
        return $totalCars;
    }


    public function capacity_count(): int {
        $capacity = 0;
        foreach($this->floors as $floor) {
            $capacity += $floor->capacity_count();
        }
        return $capacity;
    }


    /*-----park_cars adesso non funziona! Non rende le rimanenti al piano successivo! */

    // rende quelle che rimangono fuori
    public function park_cars(int $num): int {
        foreach($this->floors as $floor) {
            if($num <= 0){
                return 0;
            }
            $num = $floor->park_cars($num);
        }
        return $num;
    }

    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num, string $fromWhere): int {
        switch($fromWhere){  
            case "bottom":
             foreach(array_reverse($this->floors) as $floor) {
                $num = $floor->leave_cars($num);
                }  
             break;
            case "top":
                foreach(($this->floors) as $floor) {
                $num = $floor->leave_cars($num);
                } 
                
             break;
            case "random":
                /*
                // ----- ricorsivo in coda: ----- //
                // La funzione passa il risultato parziale alla chiamata successiva (tramite un "accumulatore")
                */
                
                foreach($this->floors as $floor) {
                // capire qual è il piano con più macchine parcheggiate
                    $moreCars = max($this->cars_distribution());
                    $num = $moreCars->leave_cars($num);
                    
                // dopo il piano più pieno va in uno a caso o in quello leggermente meno pieno?
                // $x = rand(0, count($this->floors));
                }
             break;
             // poi dovrà essere testabile (guardare slides, si parla di numeri random)
            }
        return $num;
    }

    private function indexFloor($array): int {
        // può essere un metodo statico
        $index = array_rand($array);
        return $index;  // indice stringa da cui prendo randomicamente
    }

    public function cars_distribution(): array {
        $distribution = [];
        foreach($this->floors as $floor) {
            $distribution[] = $floor->cars_count();
        }
        return $distribution;
        
    }


    public function add_reservation(): bool {
        foreach($this->floors as $floor) {
            if($floor->add_reservation()) {  // se l'ho aggiunta al piano ritorno true
                return true;
            }
        }
        return false; // sennò si va al piano successivo
    }


    public function close_floor($floor): void {
        $floor->set_close();  // lo chiudiamo con il metodo ad hoc creato di là
        $cars_floor = $floor->cars_count(); // conto le auto
        $prenotazioni = $floor->reservation_count(); // conto i posti prenotati

        // tolgo e aggiungo le prenotazioni con un ciclo perché le prende una per volta
        $i = 0;
        while($i < $prenotazioni) {   
            $floor->remove_reservation();
            $this->add_reservation();
            $i++;
        }
        
        $floor->leave_cars($cars_floor); // tolgo le macchiene dal piano
        $this->park_cars($cars_floor); // adesso invece le aggiungo a un altro piano
    }

 
    public function open_floor($floor): void{
        $floor->set_open_floor();
    }


    public function report() {
        $numero = 1;
        foreach($this->floors as $floor){
            $empty_park_cars = $floor->capacity_count() - $floor->cars_count() - $floor->reservation_count();
            echo "Piano ".$numero."\n";
            echo "Posti occupati: ".$floor->cars_count()."\n";
            echo "Posti liberi: ".$empty_park_cars."\n";
            echo "Posti prenotati: ".$floor->reservation_count()."\n\n";
            $numero = $numero + 1; // lo aggiorno per incrementarlo in ogni piano
            }
    }



}