<?php 

namespace Navarik\Zoo {

    class Animal {

        public float $health;
        
        public function __construct( float $health = 100.0 ) {
            $this->health = $health;
        }

        public function __toString() {
            return get_class($this);
        }
    }

}