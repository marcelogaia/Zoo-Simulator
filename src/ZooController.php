<?php 

namespace Navarik {

    class ZooController {
        private static int $day = 0;
        private static int $hour = 0;
        private static int $minute = 0;

        private static array $animals = [
            'monkeys' => [],
            'giraffes' => [],
            'elephants' => [],
        ];

        public static function getTime() : void{
            throw new \Exception('Not implemented');
        }

        public static function passTime( int $hours = 1 ) : void{
            // hour++
            // for( animal in animals)
            //     animal->age( hour );
        }

        public static function feedAnimals() : void {
            throw new \Exception('Not implemented');
        }

        public static function startZoo() : void {
            // start session
            throw new \Exception('Not implemented');
        }
        
        public static function closeZoo() : void {
            // destroy session
            throw new \Exception('Not implemented');
        }

        private static function saveState() : void {
            throw new \Exception('Not implemented');
        }

        public static function render( $action ) : void {
            $loader = new \Twig\Loader\FilesystemLoader('templates');
            $twig = new \Twig\Environment($loader, [
                'cache' => '/path/to/compilation_cache',
            ]);
            echo $twig->render('index.twig', [ 'action' => $action ]);
        }
    }
}
