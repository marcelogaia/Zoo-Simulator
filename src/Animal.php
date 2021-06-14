<?php 

namespace Navarik\Zoo {

    abstract class Animal {

        public bool $alive;
        public float $health;
        public string $hpColor;
        
        public function __construct( float $health = 100.0 ) {
            $this->health = $health;
            $this->alive = true;
            $this->updateHpColor();
        }

        public function __toString() {
            return get_class($this);
        }

        public function eat( float $healthAmount ) : void {
            if( $this->alive ) {
                $this->health = max( 0.0, min( [100.0, $this->health + $healthAmount ]) ); // max 100, min 0.
            }
            $this->updateHpColor();
        }

        public function age() {
            if( $this->alive ) {
                $dp = 100; // Decimal precision.
                $ageAmount = mt_rand( 0, 20 * $dp ) / $dp;
                $this->health -= $ageAmount;
            }
            
            $this->updateLife();
            $this->updateHpColor();
        }

        public abstract function updateLife() : void;
        public abstract function updateHpColor() : void;
    }

}