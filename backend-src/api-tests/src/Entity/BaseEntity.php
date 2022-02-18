<?php

namespace App\Entity;


abstract class BaseEntity {

   /**
     * Encode as string
     *
     * @return string
     */
    public function __toString() {
        return $this->export();
    }


    
    /**
     * Import an array items to this object
     *
     * @param array $array
     * @return self
     */
    public function import(array $array) : self{
        foreach ($array as $key => $value) {
            $this->importField($key, $value);
        }
        return $this;
    }


    /**
     * Return a string 
     *
     * @return string
     */
    public function export() : string {
        return \json_encode($this->toArray());
    }


    protected abstract function importField($key, $value);
    public abstract function toArray() : array;

}