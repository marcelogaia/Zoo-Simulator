<?php 

namespace Navarik\Zoo {

    class Monkey extends Animal {

        /**
         * Implements {@link Animal::updateLife()}, setting the specific rules about death 
         * for the Monkey class and updating its status.
         */
        public function updateLife() : void {
            if( $this->isAlive && $this->health < 30 ) {
                $this->isAlive = false;
            }
        }

        /**
         * Implements {@link Animal::updateHpColor()}, updating the health bar color based 
         * on the current danger of the Monkey.
         */
        public function updateHpColor() : void {
            if( ! $this->isAlive ) {
                $this->hpColor = 'gray';
                return;
            }
            
            $this->hpColor = 'red';

            if( $this->health > 50 ) {
                $this->hpColor = 'yellow';
            }

            if( $this->health > 90 ) {
                $this->hpColor = 'green';
            }
        }
    }

}