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

    // rende quelle che rimangono fuori
    public function park_cars(int $num): int {
        foreach($this->floors as $floor) {
            $num = $floor->park_cars($num);
        }
        return $num;
    }

    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num): int {
        foreach(array_reverse($this->floors) as $floor) {
            $num = $floor->leave_cars($num);
        }
        return $num;
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
        $carsReali = $floor->cars_count();

        // tolgo le prenotazioni con un ciclo perché le prende una per volta
        // meglio fare un while
        $prenotazioni = $floor->reservation_count();
        for($i = 0; $i < $prenotazioni; $i++) {
            $floor->remove_reservation();
            $this->add_reservation();
        }
        
        $floor->leave_cars($carsReali); // tolgo le macchiene dal piano
        $this->park_cars($carsReali); // adesso invece le aggiungo a un altro piano

        // devo prima capire quante ne rimangono fuori per vedere quante ne vanno nel prossimo piano
    }

    /*
    public function open_floor($floor): void{
        
    }

    public function report(): string{
        
    }

    */

}