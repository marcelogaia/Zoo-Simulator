<?php 

namespace Navarik\Zoo {

    abstract class Animal {

        public bool $isAlive;
        public float $health;
        public string $hpColor;
        
        public function __construct( float $health = 100.0 ) {
            $this->health = $health;
            $this->isAlive = true;
            $this->updateHpColor();
        }

        /** 
         * The current animal eats, regenerations its health by a specific percentage of its current health.
         * 
         * @param $healthAmount The percentage that the animal will be regenerated.
         */
        public function eat( float $healthAmount ) : void {
            if( $this->isAlive ) {
                $healthRegen = $this->health * ($healthAmount / 100 );
                $this->health = min( [ 100.0, $this->health + $healthRegen ] ); // max 100
            }
            $this->updateHpColor();
        }

        /** 
         * Ages the current animal, reducing its health by 0 to 20% of its current health.
         */
        public function age() : void {
            if( $this->isAlive ) {
                $dp = 100; // Decimal precision.
                $ageAmount = mt_rand( 0, 20 * $dp ) / $dp;
                $healthLost = $this->health * ($ageAmount / 100);
                $this->health = $this->health - $healthLost;
            }
            
            $this->updateLife();
            $this->updateHpColor();
        }

        /**
         * Must define the current life status of each animal based on its own rules.
         */
        public abstract function updateLife() : void;
        

        /**
         * Must define the threshholds that'll control the life bar on each type of animal.
         */
        public abstract function updateHpColor() : void;
    }

}