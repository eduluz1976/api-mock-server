<?php

namespace App\Service;


use \App\Constants;
use \App\Entity\RequestEntity;
use \App\Factory\RequestFactory;
use \App\Exception\RequestNotFoundException;
use \App\Exception\InvalidInputException;
use \App\Utils\RequestUtils;

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

        $this->getRedisClient()->hSet('request',$this->getKey($transactionId), $request->export());

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


        $data = $this->getRedisClient()->hget('request',$this->getKey($transactionId));
        
        if (!$data) {
            throw new RequestNotFoundException("Request with id $transactionId was not found");
        }

        $request = RequestFactory::makeEntity($data);

        return $request;
    }



    public function getAll() {


        $ls = $this->getRedisClient()->hGetAll('request');

        $myLs = [];
        $requests = [];

        // $currOrigin = 

        foreach ($ls as $transactionId => $requestArr) {

            $request = RequestFactory::makeEntity($requestArr);


            $requests[] = $request;

            // if ($request)
            // $origin = $request->getOrigin();
            // $selector = $request->getSelector();


            // if ($selector['condition'] === 'match-all') {


            //     if ()

            // }


            // $myLs[] = 
        }

        return $requests;

        // echo "<pre>";
        // print_r($myLs);
        // print_r($ls);
        // exit;
    }

}