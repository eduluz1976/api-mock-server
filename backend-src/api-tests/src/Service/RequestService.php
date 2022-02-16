<?php

namespace App\Service;


use \App\Constants;
use \App\Entity\RequestEntity;
use \App\Factory\RequestFactory;
use \App\Exception\RequestNotFoundException;
use \App\Exception\InvalidInputException;

class RequestService {



    /** @var  \Predis\Client */
    private $redisClient;


    protected function getRedisClient() {
        if (!$this->redisClient) {
            $this->redisClient = new \Predis\Client(['host'=>'redis']);
        }
        return $this->redisClient;
    }

    protected function getKey($transactionId) {
        return 'request:'.$transactionId;
    }



    public function save($request) {

        $transactionId = hash('sha256', time());

        $request = $this->setFieldsToSave($request, $transactionId);

        $this->getRedisClient()->set($this->getKey($transactionId), $request->export());

        return $transactionId;
    }


    protected function setFieldsToSave($request, $transactionId) {
        $request->setTransactionId($transactionId);
        $request->setStatus(Constants::REQUEST_STATUS_PENDING);
        return $request;
    }


    protected function validateTransactionId($transactionId) {
        if (strlen($transactionId) !== 64) {
            throw new InvalidInputException("Invalid transactionId");
        }
    }


    /**
     * Return a given Request
     *
     * @param string $transactionId
     * @return RequestEntity
     */
    public function get($transactionId) {

        $this->validateTransactionId($transactionId);


        $data = $this->getRedisClient()->get($this->getKey($transactionId));
        
        if (!$data) {
            throw new RequestNotFoundException("Request with id $transactionId was not found");
        }

        $request = RequestFactory::makeEntity($data);

        return $request;
    }


}