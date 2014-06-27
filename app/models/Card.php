<?php

class Card extends Eloquent {
    public function set() {
        $this->hasOne('Set');
    }

    public function mcmData() {
        $this->hasOne('McmData');
    }
}