<?php declare(strict_types=1);

class Parking{

    // proprietà: parcheggio composto da piani
    private array $floors;

    //-------- metodi

    // rende un piano, che è un oggetto di classe ParkingFloor
    public function add_floor(ParkingFloor $floor): void{
        $this->floors[] = $floor;
    }


    public function cars_count(): int{
        $totalCars = 0;
        foreach($this->floors as $floor){
            // per ogni piano conto le macchine
            $carsFloor = $floor->cars_count();
            // aggiungo al totale
            $totalCars = $totalCars + $carsFloor;
        }
        return $totalCars;
    }


    public function capacity_count(): int{
        $capacity = 0;
        foreach($this->floors as $floor){
            $capacityFloor = $floor->capacity_count();
            $capacity = $capacity + $capacityFloor;
        }
        return $capacity;
    }

    // rende quelle che rimangono fuori
    public function park_cars(int $num): int{
        foreach($this->floors as $floor){
            $num = $floor->park_cars($num);
        }
        return $num;
    }

    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num): int{
        foreach(array_reverse($this->floors) as $floor){
            $num = $floor->leave_cars($num);
        }
        return $num;
    }


    public function cars_distribution(): array{
        $distribuzione = [];
        foreach($this->floors as $floor){
            $carFloors = $floor->cars_count();
            $distribuzione[] = $carFloors;
        }
        return $distribuzione;
        
    }


    public function add_reservation(): bool{
        foreach($this->floors as $floor){
            // se l'aggiunta al piano ritorno true
            if($floor->add_reservation()){return true;}
            }
            // sennò si va al piano successivo
            return false;
    }


    public function close_floor($floor): void{
        // lo chiudiamo con il metodo ad hoc creato di là
        $floor->setOpenToFalse();

        $carsReali = $floor->cars_count();

        // tolgo le prenotazioni con un ciclo perché le prende una per volta
        $prenotazioni = $floor->reservation_count();

        
        for($i = 0; $i < $prenotazioni; $i++){
            $floor->remove_reservation();
            $this->add_reservation();
        }

        // tolgo le macchiene dal piano
        $floor->leave_cars($carsReali);

        // adesso invece le aggiungo al piano successivo
        foreach($this->floors as $floor){
            // quindi se il piano è aperto sposto lì macchine e prenotati
            if($floor->isOpenFloor()){
                // fo un ciclo perché sennò conta una prenotazione per volta
                for($i = 0; $i < $prenotazioni; $i++){
                    $floor->add_reservation();
                }
            }
        }
        $this->park_cars($carsReali);
                // devo prima capire quante ne rimangono fuori per vedere quante ne vanno nel prossimo piano
    }

    /*
    public function open_floor($floor): void{
        
    }

    public function report(): string{
        
    }

    */

}