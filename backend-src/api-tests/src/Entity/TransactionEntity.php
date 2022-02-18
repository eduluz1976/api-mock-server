<?php

namespace App\Entity;


class TransactionEntity extends BaseEntity  {

    protected $transactionId;
    protected $createdAt;
    protected $steps = [];
    protected $nextIndexStep = 0;    

    const TRANSACTION_ID = 'transactionId';
    const CREATED_AT = 'createdAt';
    const STEPS = 'steps';
    const NEXT_INDEX_STEP = 'nextIndexStep';


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
     * Get the value of nextIndexStep
     */ 
    public function getNextIndexStep()
    {
        return $this->nextIndexStep;
    }

    /**
     * Set the value of nextIndexStep
     *
     * @return  self
     */ 
    public function setNextIndexStep($nextIndexStep)
    {
        $this->nextIndexStep = $nextIndexStep;

        return $this;
    }


    public function incrementNextIndexStep() {
        $this->nextIndexStep++;
        return $this;
    }



    /**
     * Check if this object has more steps to perform
     *
     * @return boolean
     */
    public function hasAvailableNextStep() : bool {
        if (count($this->steps) > $this->getNextIndexStep()) {
             return true;
        }
        return false;
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
            case self::STEPS: $this->setSteps($value); break;
            case self::NEXT_INDEX_STEP: $this->setNextIndexStep($value); break;
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
            self::CREATED_AT => $this->getCreatedAt(),
            self::STEPS => $this->getSteps(),
            self::NEXT_INDEX_STEP => $this->getNextIndexStep(),
        ];
    }

    

}
