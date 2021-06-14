<?php 
/**
 * ZooController manages the application status, session and behavior, including the current
 * time and the status of each one of the animal. Also responsible for rendering the right
 * template according to the whether or not the Zoo is open.
 */

namespace Navarik\Zoo {

    /**
     * Class ZooController, which controlles the whole application state and manages the Zoo.
     */
    class ZooController {

        private static array $time;

        private static array $animals;

        /**
         * Returns whether or not the Session has started, or "Zoo has opened."
         * @return bool Is the Zoo open?
         */
        private static function zooStarted() : bool {
            return isset( $_SESSION['started'] ) && $_SESSION['started'];
        }

        /**
         * Formats the time to be shown in the UI.
         * 
         * @return string Current time in the zoo. Format: 'Day 01 - 4 am'.
         */
        public static function getTime() : string{
            $t = (object) self::$time;
            $h = $t->hour == 0 ? 12 : $t->hour;
            $h = $h > 12 ? $h-12 : $h;
            
            $h = sprintf("%02d", $h );
            $ampm = $t->hour < 12 ? 'am' : 'pm';
            
            return  "Day $t->day - $h $ampm";
        }

        /**
         * Triggers the passage of time by the amount determined. With the passage of time,
         * it also triggers the effect of hunger in each of the animals.
         * @param int $hours Amount of hours to be passed.
         */
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

        /**
         * Feeds all the (alive) animals in the Zoo, healing each type of animal
         * by the same random amount (from 10.00 to 25.00).
         */
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

        /**
         * Starts the zoo, creating all the animals all full health.
         * Called by ?action=start or clicking the Button: "Start the zoo".
         */
        public static function startZoo() : void {
            self::init();
            $_SESSION['started'] = true;

            for( $i = 0; $i < 5; $i++ ) {
                self::$animals['monkeys'][$i] = new Monkey();
                self::$animals['giraffes'][$i] = new Giraffe();
                self::$animals['elephants'][$i] = new Elephant();
            }
            self::saveState();
        }
        
        /**
         * Closes the zoo and remove all data from session.
         */
        public static function closeZoo() : void {
            session_start();
            $_SESSION = array();
            session_destroy();
        }

        /** 
         * Saves current animal and time information into the session to be used for 
         * later requests.
         */
        private static function saveState() : void {
            if ( self::zooStarted() ) {
                $_SESSION['time'] = self::$time;
                $_SESSION['animals'] = self::$animals;
            }
        }

        /**
         * Renders the template using Twig
         * @link https://twig.symfony.com/doc/3.x/ Twig
         */
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

        /**
         * Simply starts the session and populates the static properties with data from 
         * the session if any, or with the default values.
         */
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
