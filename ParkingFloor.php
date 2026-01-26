<?php declare(strict_types=1);

class ParkingFloor{

    private int $cars = 0;
    private int $capacity;

    // ----- costruttore
    public function __construct(int $num){
        $this->capacity = $num;
    }

    //-------- metodi

    public function cars_count(): int{
        return $this->cars;
    }

    public function capacity_count(): int{
        return $this->capacity;
    }

    // rende quelle che rimangono fuori
    public function park_cars(int $num): int{
        $empty_park_cars = $this->capacity - $this->cars;

        // non rimane fuori nessuno
        if($empty_park_cars > $num){
            // alle macchine parcheggiate si aggiunge $num
            $this->cars = $this->cars + $num;
            return 0;
        }
  
        // le macchine parcheggiate adesso sono uguali alla capienza
        $this->cars = $this->capacity;

        $empty_park_cars = $num - $empty_park_cars; 
        return $empty_park_cars; // * -1 per trasformare num negativo in positivo
    }


    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num): int{

        // quelle che se ne vanno non possono essere più di quelle parcheggiate
        if($num > $this->cars){
            return $this->cars - $num;
        }
        
        // aggiorno le macchine facendo:
        // macchine parcheggiate - quelle che se ne vanno 
        $now_cars = $this->cars - $num;
        return $now_cars;   
    }

    
    /*
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