<?php 

namespace Navarik\Zoo {

    class ZooController {

        private static array $time;

        private static array $animals;

        private static function zooStarted() : bool {
            return isset( $_SESSION['started'] ) && $_SESSION['started'];
        }

        public static function getTime() : string{
            $t = (object) self::$time;
            $h = sprintf("%02d", $t->hour );
            $m = sprintf("%02d", $t->minute );
            return  "Day $t->day - $h:$m";
        }

        public static function getAnimals() : array{
            return self::$animals;
        }

        public static function passTime( int $hours = 1 ) : void {
            self::init();
            self::$time['hour'] = $_SESSION['time']['hour'] + $hours;
            self::$time['day'] = $_SESSION['time']['day'];

            if( self::$time['hour'] >= 24 ) {
                self::$time['day']++;
                self::$time['hour'] -= 24;
            }

            // TODO: Age the animals.
            // foreach( self::$animals as animal )
            //     animal->age( $hours );
            self::saveState();
        }

        public static function feedAnimals() : void {
            self::init();
            foreach( self::$animals  as $group ) {
                $dp = 100; // Decimal precision.
                $foodAmount = mt_rand( 10 * $dp, 25 * $dp ) / $dp;
                foreach( $group as $animal ) {
                    $animal->eat( $foodAmount );
                }
            }
            
            self::saveState();
        }

        public static function startZoo() : void {
            self::init();
            $_SESSION['started'] = true;

            for( $i = 0; $i < 5; $i++ ) {
                array_push( self::$animals['monkeys'], new Monkey() );
                array_push( self::$animals['giraffes'], new Giraffe() );
                array_push( self::$animals['elephants'], new Elephant() );
            }
            self::saveState();
        }
        
        public static function closeZoo() : void {
            session_start();
            $_SESSION = array();
            session_destroy();
        }

        private static function saveState() : void {
            if ( self::zooStarted() ) {
                $_SESSION['time'] = self::$time;
                $_SESSION['animals'] = self::$animals;
            }
        }

        public static function render() : void {
            self::init();
            $loader = new \Twig\Loader\FilesystemLoader('templates');
            $twig = new \Twig\Environment($loader);
            
            if ( self::zooStarted() ) {
                echo $twig->render( 
                    'index.twig', 
                    [
                        'time'    => self::getTime(),
                        'animals' => self::getAnimals()
                    ]
                );
            } else {
                echo $twig->render( 'start.twig' );
            }
        }

        public static function init() {
            session_start();
            self::$time = $_SESSION['time'] ?? [
                'day' => 1,
                'hour' => 0,
                'minute' => 0
            ];

            self::$animals = $_SESSION['animals'] ??[
                'monkeys' => [],
                'giraffes' => [],
                'elephants' => [],
            ];
        }
    }
}
