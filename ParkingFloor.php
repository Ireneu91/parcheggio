<?php declare(strict_types=1);

class ParkingFloor{

    private int $capacity;
    private int $cars = 0; // cars non tiene conto anche dei posti prenotati
    private int $reserved_spot = 0;
    private bool $is_open = true;

    //-------- costruttore ----------//
    public function __construct(int $num) {
        $this->capacity = $num;
    }



    //---------- metodi -------------//

    public function cars_count(): int {
        return $this->cars;
    }

    public function capacity_count(): int {
        return $this->capacity;
    }

    // rende quelle che rimangono fuori
    public function park_cars(int $num): int {

        if(!$this->is_open) {// se il piano è chiuso
            return $num; // tutte le macchine, perché non sei riuscito a parcheggiare
        }

        $empty_park_cars = $this->capacity - $this->cars - $this->reserved_spot;
        if($empty_park_cars >= $num) { // se non rimane fuori nessuno
            $this->cars += $num; // alle macchine parcheggiate si aggiunge $num
            return 0;
        } else {
            $this->cars += $empty_park_cars;  // le macchine parcheggiate adesso sono uguali ai posti disponibili
            return $num - $empty_park_cars; // * -1 per trasformare num negativo in positivo
        }
    }


    // rende il numero di auto che non riesce a togliere
    public function leave_cars(int $num): int {   

        if($num > $this->cars) {  // se quelle che se ne vanno sono più di quelle parcheggiate
            $difference = $num - $this->cars;
            $this->cars = 0; // dopo avrò sicuramente 0 macchine, perché se ne sono andate
            return $difference; // rendo quante macchine non sono riuscito a togliere
        } else {
            $this->cars = $this->cars - $num; // macchine parcheggiate - quelle che se ne vanno 
            return 0;   
        }
    }


    //----- prenotazioni ------//

    public function add_reservation(): bool {
        if(!$this->is_open) {
            return false;
        }
        if($this->cars + $this->reserved_spot < $this->capacity) {
            $this->reserved_spot++;
            return true;
        } else { 
            return false; 
        }
    }

    public function reservation_count(): int {
        return $this->reserved_spot;
    }


    public function remove_reservation(): void {
        if($this->reserved_spot > 0) {
            $this->reserved_spot--;
        }
    }


    //--- aprire/chiudere il piano ---//

    public function set_open_floor(): void {
        $this->is_open = true;
    }

    public function set_close(): void {
        $this->is_open = false;
    }

    public function report() {
        $empty_park_cars = $this->capacity - $this->cars - $this->reserved_spot;
        echo "Posti liberi: ".$empty_park_cars."\n";
        echo "Posti prenotati: ".$this->reservation_count()."\n\n";
    }

}