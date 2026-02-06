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
                // - Trovo il piano che ha attualmente più auto.
                   - Tolgo una (o un piccolo gruppo di) auto da quel piano.
                   - Ripeto l'operazione: ricalcolo chi è il più pieno (perché dopo il prelievo il "vincitore" potrebbe essere cambiato) e tolgo la prossima auto.
                //
                */
                $num = $this->tailRecursion($num);

                /* ------------- inizialmente era così, poi ho usato la funzione ricorsiva --------- */

                // while ($num > 0){
                //     $distribution = $this->cars_distribution();
                //     $mostCars = max($distribution);
                //     $mostCarIndex = array_search($mostCars, $distribution);
                //     $risultato = $this->floors[$mostCarIndex]->leave_cars(1); // ne tolgo una alla volta così da ricalcolare via via quale diventa il piano con più macchine
                    
                //     if ($risultato == 1) { // se il piano è vuoto, si esce dal loop
                //         break; 
                //     }
                //     $num--; // Aggiorna il conteggio totale delle auto rimaste da togliere
                // }

                break;          

             // poi dovrà essere testabile (guardare slides, si parla di numeri random)
            }
        return $num;
    }

    // private function indexFloor($array): int {
    //     // può essere un metodo statico
    //     $index = array_search($array, $array);
    //     return $index;  // indice stringa da cui prendo randomicamente
    // }


    // ----- RICORSIVO IN CODA: ----- //
    // l'ultima operazione della funzione è la chiamata a se stessa, passando il risultato parziale (lo stato aggiornato) come argomento della chiamata successiva (tramite un "accumulatore")

    // Per rendere la randomica TESTABILE con dependency injiection, aggiungiamo il parametro $generatore. 
    // ?callable: Il punto di domanda indica che il parametro può essere o una funzione o null..
    // Perché PHP non accetta stringhe nei valori di default dei parametri, quindi assegnamo 'rand' subito dopo
    public function tailRecursion(int $num, ?callable $generator = null){
        if($num <= 0){
            return 0;
        }

        // Se non è stata passata una funzione, usiamo 'rand' di default
        if ($generator === null) {
            $generator = 'rand'; 
        }

        $distribution = $this->cars_distribution();
        $totalCars = array_sum($distribution);
        if($totalCars == 0){
            return $num; // il parcheggio è vuoto, quindi non ne abbiamo tolta nessuna
        }

        /*------ non usiamo più max(), ma rand() ---------- */
        // $mostCars = max($distribution);
        // $mostCarIndex = array_search($mostCars, $distribution);

        // 1. Generiamo un "ticket" casuale tra 1 e il totale delle auto nel garage
        $ticket = $generator(1, $totalCars); // quindi abbiamo un randomico tra le macchine di tutti i piani
        $accumulator = 0;
        $selectedFloorIndex = 0;

        // --------- esempio:
        // Piano 0: 5 auto (Soglia: 5)
        // Piano 1: 80 auto (Soglia: 5 + 80 = 85)
        // Piano 2: 15 auto (Soglia: 85 + 15 = 100)
        //
        // Se rand() estrae 3, il primo if (3 <= 5) è vero ----------> Piano 0.
        // Se rand() estrae 50, il primo if (50 <= 5) è falso, ma il secondo if (50 <= 85) è vero ----> Piano 1.

        // 2. Cerchiamo a quale piano corrisponde il ticket
        foreach ($distribution as $index => $count) {
            $accumulator += $count; // aggiungiamo le auto del piano all'accumulatore per creare la "soglia"
            if ($ticket <= $accumulator) { // se il ticket è <= alla soglia attuale riguarda questo piano
                $selectedFloorIndex = $index;
                break; // Abbiamo trovato il piano, usciamo dal foreach
            }
        }

        $risultato = $this->floors[$selectedFloorIndex]->leave_cars(1); // ne tolgo una alla volta così da ricalcolare via via quale diventa il piano con più macchine

        if($risultato === 0){
           return $this->tailRecursion($num - 1, $generator); // Se il prelievo è riuscito, richiamiamo la funzione passando $num diminuito di 1.
        } else {
            return $this->tailRecursion($num, $generator); // Se il prelievo è fallito (caso raro se il garage non è vuoto), riproviamo senza diminuire $num, così da ricalcolare il piano.
        }
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