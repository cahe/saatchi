<?php

class Card extends Eloquent {
    public function set() {
        return $this->belongsTo('Set');
    }

    public function mcmData() {
        return $this->hasOne('McmData');
    }
}