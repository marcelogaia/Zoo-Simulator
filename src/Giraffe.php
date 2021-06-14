<?php 

namespace Navarik\Zoo {

    class Giraffe extends Animal {

        
        /**
         * Implements {@link Animal::updateLife()}, setting the specific rules about death 
         * for the Giraffe class and updating its status.
         */
        public function updateLife() : void {
            if( $this->isAlive && $this->health < 50 ) {
                $this->isAlive = false;
            }
        }

        /**
         * Implements {@link Animal::updateHpColor()}, updating the health bar color based 
         * on the current danger of the Giraffe.
         */
        public function updateHpColor() : void {
            
            if( ! $this->isAlive ) {
                $this->hpColor = 'gray';
                return;
            }
            
            $this->hpColor = 'red';

            if( $this->health > 70 ) {
                $this->hpColor = 'yellow';
            }

            if( $this->health > 90 ) {
                $this->hpColor = 'green';
            }
        }
    }

}