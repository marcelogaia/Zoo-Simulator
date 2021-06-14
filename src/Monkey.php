<?php 

namespace Navarik\Zoo {

    class Monkey extends Animal {

        public function updateLife() : void {
            if( $this->alive && $this->health < 30 ) {
                $this->alive = false;
            }
        }

        public function updateHpColor() : void {
            if( ! $this->alive ) {
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