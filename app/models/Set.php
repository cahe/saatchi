<?php

class Set extends Eloquent {
    public function card(){
        return $this->hasMany('Card');
    }
}