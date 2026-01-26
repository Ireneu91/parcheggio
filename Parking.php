<?php declare(strict_types=1);

class Parking{

    private int $car;
    private int $place;
    private int $empty_place;

    // ----- costruttore
    public function __construct(int $place)
    {
        $this->place = $place;
        $this->empty_place = $place;

        // alla fine penso alle eccezioni
        throw new \Exception('Not implemented');
    }
    
    //----- validatori



    //-------- metodi

    /*
    public function cars_count(): int{
        
    }

 
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
    */

}