<?php 

namespace Navarik\Zoo {

    class ZooController {

        private static array $time = [
            'day' => 0,
            'hour' => 0,
            'minute' => 0
        ];

        private static array $animals = [
            'monkeys' => [],
            'giraffes' => [],
            'elephants' => [],
        ];

        private static function zooStarted() : bool {
            return isset( $_SESSION['started'] ) && $_SESSION['started'];
        }

        public static function getTime() : string{
            $t = (object) self::$time;
            $d = $t->day>0 ? "Day $t->day - " : '';
            $h = sprintf("%02d", $t->hour );
            $m = sprintf("%02d", $t->minute );
            return  $d . "$h:$m";
        }

        public static function getAnimals() : array{
            return self::$animals;
        }

        public static function passTime( int $hours = 1 ) : void {
            self::$time['hour'] += $hours;
            if( self::$time['hour'] + $hours >= 24 ) {
                self::$time['day']++;
                self::$time['hour'] -= 24;
            }

            // TODO: Age the animals.
            // foreach( self::$animals as animal )
            //     animal->age( $hours );
            self::saveState();
        }

        public static function feedAnimals() : void {
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
            session_start();
            $_SESSION['started'] = true;
            self::$animals['monkeys'] = array_fill( 0,5, new Monkey() );
            self::$animals['giraffes'] = array_fill( 0,5, new Giraffe() );
            self::$animals['elephants'] = array_fill( 0,5, new Elephant() );

            self::$animals['monkeys'][3]->health = 50.0;
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

        private static function loadState() : void {
            session_start();
            if ( self::zooStarted() ) {
                self::$time = $_SESSION['time'] ?? [];
                self::$animals = $_SESSION['animals'] ?? [];
            }
        }

        public static function render() : void {
            self::loadState();
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
    }
}
