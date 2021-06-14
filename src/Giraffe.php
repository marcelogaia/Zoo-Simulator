<?php 

namespace Navarik\Zoo {

    class Giraffe extends Animal {

        public function updateLife() : void {
            if( $this->alive && $this->health < 50 ) {
                $this->alive = false;
            }
        }

        public function updateHpColor() : void {
            
            if( ! $this->alive ) {
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