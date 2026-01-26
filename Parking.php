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

 /*
    public function capacity_count(): int{
        return $this->capacity_count();
    }

    // rende quelle che rimangono fuori
    public function park_cars(int $num): int{
        
    }

    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num): int{
        
    }

    public function cars_distribution(): array{
        
    }

    public function add_reservation(): void{
        
    }

    public function reservation_count(): int{
        
    }

    public function remove_reservation(): void{
        
    }

    public function open_floor($floor): void{
        
    }

    public function close_floor($floor): void{
        
    }

    public function report(): string{
        
    }

    */

}