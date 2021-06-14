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
            $h = $t->hour == 0 ? 12 : $t->hour;
            $h = $h > 12 ? $h-12 : $h;
            
            $h = sprintf("%02d", $h );
            $ampm = $t->hour < 12 ? 'am' : 'pm';
            
            return  "Day $t->day - $h $ampm";
        }

        public static function passTime( int $hours = 1 ) : void {
            self::init();
            self::$time['hour'] = $_SESSION['time']['hour'] + $hours;
            self::$time['day'] = $_SESSION['time']['day'];

            if( self::$time['hour'] >= 24 ) {
                self::$time['day']++;
                self::$time['hour'] -= 24;
            }

            foreach( self::$animals  as $group ) {
                foreach( $group as $animal ) {
                    $animal->age( $foodAmount );
                }
            }

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
                        'animals' => self::$animals
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

            self::$animals = $_SESSION['animals'] ?? [
                'monkeys' => [],
                'giraffes' => [],
                'elephants' => [],
            ];
        }
    }
}
