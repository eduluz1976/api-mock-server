<?php

namespace App\lib;


class DataRepository {

    protected $list = [];

    public function getItem($key, $default=null) {
        return (isset($this->list[$key])) ? $this->list[$key] : $default;
    } 

    public function addItem($key, $data) {
        $this->list[$key] = $data;
    }
    

}