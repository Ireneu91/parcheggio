<?php declare(strict_types=1);

namespace App\Tests;

use App\Models\ParkingFloor;
use App\Models\Parking;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TestParking extends TestCase {

    public function testRandom(){
        $floor1 = new ParkingFloor(50);
        $floor2 = new ParkingFloor(30);
        $floor3 = new ParkingFloor(10);
        $parking = new Parking();
        $parking->add_floor($floor1);
        $parking->add_floor($floor2);
        $parking->add_floor($floor3);
        $parking->park_cars(80);
        $parking->report();

    }
}