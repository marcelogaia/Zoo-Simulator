<?php 

namespace Navarik\Zoo {

    class Elephant extends Animal {
        private bool $canWalk = true;

        /**
         * It has the same behavior of {@link Animal::eat()}, apart from updating the elephant's 
         * ability to walk, given enough health regenerated.
         * 
         * @see function Animal::eat()
         */
        public function eat( float $healthAmount ): void {
            parent::eat( $healthAmount );
            $this->updateCanWalk();
            $this->updateHpColor();
        }

        /**
         * It has the same behavior of {@link Animal::eat()}, apart from updating the elephant's 
         * ability to walk, given enough health regenerated.
         * 
         * @see function Animal::eat()
         */
        public function age() : void {
            parent::age();
            $this->updateCanWalk();
            $this->updateHpColor();
        }

        /**
         * Unique to the Elephant class, it updates the current walking ability of the Elephant,
         * depending on how much health it current has.
         */
        private function updateCanWalk() : void {
            $this->canWalk = $this->health >= 70;
        }

        /**
         * Implements {@link Animal::updateLife()}, setting the specific rules about death 
         * for the Elephant class and updating its status.
         */
        public function updateLife() : void {
            if( $this->isAlive && ! $this->canWalk ) {
                $this->isAlive = false;
            }
        }

        /**
         * Implements {@link Animal::updateHpColor()}, updating the health bar color based 
         * on the current danger of the Elephant.
         */
        public function updateHpColor() : void{
            if( ! $this->isAlive ) {
                $this->hpColor = 'gray';
                return;
            }
            $this->hpColor = 'yellow';
            
            if( ! $this->canWalk ) {
                $this->hpColor = 'red';
            }

            if( $this->health > 90 ) {
                $this->hpColor = 'green';
            }
        }
    }

}