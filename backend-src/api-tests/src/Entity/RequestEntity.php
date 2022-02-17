<?php

namespace App\Entity;


class RequestEntity {

    protected $transactionId;
    protected $steps;
    protected $status;
    protected $createdAt;

    const TRANSACTION_ID = 'transactionId';
    const STEPS = 'steps';
    const STATUS = 'status';
    const CREATED_AT = 'createdAt';

    public function __construct() {
        $this->setCreatedAt(gmdate('Y-m-d H:i:s'));
    }



    /**
     * Get the value of transactionId
     */ 
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set the value of transactionId
     *
     * @return  self
     */ 
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get the value of steps
     */ 
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set the value of steps
     *
     * @return  self
     */ 
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

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

    /**
     * Import all fields into this object
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    protected function importField($key, $value) {
        switch ($key) {
            case self::TRANSACTION_ID: $this->setTransactionId($value); break;
            case self::STATUS: $this->setStatus($value); break;
            case self::STEPS: $this->setSteps($value); break;
        }
    }


    /**
     * Undocumented function
     *
     * @return array
     */
    public function toArray() : array {
        return [
            self::TRANSACTION_ID => $this->getTransactionId(),
            self::STATUS => $this->getStatus(),
            self::STEPS => $this->getSteps(),
            self::CREATED_AT => $this->getCreatedAt(),
        ];
    }

    
}