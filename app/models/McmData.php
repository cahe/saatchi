<?php

class McmData extends Eloquent {
    protected $table = 'mcm_data'; //already plural

    public function card() {
        $this->hasOne('Card');
    }
}