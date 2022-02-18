<?php


namespace App\Service;


abstract class BaseService {
    /** @var  \Predis\Client */
    protected $redisClient;


    protected function getRedisClient() {
        if (!$this->redisClient) {
            $this->redisClient = new \Predis\Client(['host'=>'redis']);
        }
        return $this->redisClient;
    }

    protected function validateTransactionId($transactionId) {
        if (strlen($transactionId) !== 64) {
            throw new InvalidInputException("Invalid transactionId");
        }
    }

    protected abstract function getKey($transactionId) : string;
}