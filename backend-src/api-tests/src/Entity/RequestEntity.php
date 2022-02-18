<?php

namespace App\Entity;


class RequestEntity  extends BaseEntity {

    protected $transactionId;
    protected $steps;
    protected $status;
    protected $origin;
    protected $selector;
    protected $createdAt;

    const TRANSACTION_ID = 'transactionId';
    const STEPS = 'steps';
    const STATUS = 'status';
    const ORIGIN = 'origin';
    const SELECTOR = 'selector';
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
     * Get the value of origin
     */ 
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set the value of origin
     *
     * @return  self
     */ 
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get the value of selector
     */ 
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Set the value of selector
     *
     * @return  self
     */ 
    public function setSelector($selector)
    {
        $this->selector = $selector;

        return $this;
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
            case self::ORIGIN: $this->setOrigin($value); break;
            case self::SELECTOR: $this->setSelector($value); break;
            case self::CREATED_AT: $this->setCreatedAt($value); break;
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
            self::ORIGIN => $this->getOrigin(),
            self::SELECTOR => $this->getSelector(),
            self::CREATED_AT => $this->getCreatedAt(),
        ];
    }

    

}