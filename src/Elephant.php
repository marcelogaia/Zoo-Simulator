<?php 

namespace Navarik\Zoo {

    class Elephant extends Animal {
        private bool $canWalk = true;

        public function updateLife() : void {
            if( $this->alive ) {
                if( $this->health > 70) {
                    $this->canWalk = true;
                }
                if( ! $this->canWalk ) {
                    $this->alive = false;
                }
            }
        }
        public function eat( float $healthAmount ): void {
            parent::eat( $healthAmount );
            $this->updateCanWalk();
        }

        public function age() {
            parent::age();
            $this->updateCanWalk();
        }

        private function updateCanWalk() : void {
            $this->canWalk = $this->health >= 70;
            $this->updateHpColor();
        }

        public function updateHpColor() : void{
            if( ! $this->alive ) {
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