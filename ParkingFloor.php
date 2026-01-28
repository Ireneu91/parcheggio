<?php declare(strict_types=1);

class ParkingFloor{

    private int $cars = 0;
    private int $capacity;
    private int $postiPrenotati = 0;
    private bool $isOpen = true;

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
        if($this->isOpen){
            $empty_park_cars = $this->capacity - $this->cars - $this->postiPrenotati;
            
            // non rimane fuori nessuno
            if($empty_park_cars >= $num){
                // alle macchine parcheggiate si aggiunge $num
                $this->cars = $this->cars + $num;
                return 0;
            }
    
            // le macchine parcheggiate adesso sono uguali alla capienza meno i posti prenotati
            $this->cars = $this->capacity - $this->postiPrenotati;

            return $num - $empty_park_cars; // * -1 per trasformare num negativo in positivo
        }
        // se il piano è chiuso rendi tutte le macchine, perché non sei riuscito a parcheggiare
        return $num;
        
    }


    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num): int{
        // togliere le auto che può togliere
        // restituire quelle che non riesce a togliere

        // quelle che se ne vanno non possono essere più di quelle parcheggiate
        if($num > $this->cars){
            $differenza = $num - $this->cars;
            // dopo avrò sicuramente 0 macchine
            $this->cars = 0;
            // e devi dire quante macchine non sono riuscito a togliere

            return $differenza;
        }
        else
        // aggiorno le macchine facendo:
        // macchine parcheggiate - quelle che se ne vanno 
        $this->cars = $this->cars - $num;
        return 0;   
    }

    
  
    public function add_reservation(): bool{
        if($this->isOpen){
            if($this->cars + $this->postiPrenotati < $this->capacity)
                {
                    $this->postiPrenotati++;
                    return true;
            }
        }
        return false;
    }

   
    public function reservation_count(): int{
        return $this->postiPrenotati;
    }


    public function remove_reservation(): void{
        if($this->postiPrenotati > 0){
            $this->postiPrenotati--;
        }
    }

    public function isOpenFloor(): bool{
        return $this->isOpen;
    }

    public function setOpenToFalse(): void{
        $this->isOpen = false;
    }

}