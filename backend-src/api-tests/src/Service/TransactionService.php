<?php

namespace App\Service;


use \App\Constants;
use \App\Entity\RequestEntity;
use \App\Entity\TransactionEntity;
use \App\Factory\RequestFactory;
use \App\Factory\TransactionFactory;
use \App\Exception\RequestNotFoundException;
use \App\Exception\InvalidInputException;
use \App\Utils\RequestUtils;

class TransactionService extends BaseService {



    protected function getKey($transactionId) : string {
        return 'transaction:'.$transactionId;
    }




    /**
     * Return a given Request
     *
     * @param string $transactionId
     * @return RequestEntity
     */
    public function get($transactionId) {

        $this->validateTransactionId($transactionId);

        $data = $this->getRedisClient()->hget('transaction',$this->getKey($transactionId));
        
        if (!$data) {
            throw new RequestNotFoundException("transaction with id $transactionId was not found");
        }

        $request = TransactionFactory::makeEntity($data);

        return $request;
    }


    public function getOrElseCreate($transactionId) {

        try {
            $transaction = $this->get($transactionId); 
            return $transaction;
        } catch (RequestNotFoundException $ex) {

            $requestService = new RequestService();
            $request = $requestService->get($transactionId);
            return $this->createNewtransaction($request);
        } catch (\Exception $ex) {

        }

    }


    public function createNewtransaction(RequestEntity $request) {

        $transactionId = $request->getTransactionId();
        $transactionEntity = TransactionFactory::makeEntity($request);

        $this->getRedisClient()->hset('transaction',$this->getKey($transactionId), $transactionEntity->export());

        return $transactionEntity;
    }

    public function update(TransactionEntity $transactionEntity) {
        $transactionId = $transactionEntity->getTransactionId();
        $result = $this->getRedisClient()->hset('transaction',$this->getKey($transactionId), $transactionEntity->export());
        if (false === $result) {
            throw new \Exception("Error updating transaction $transactionId");
        }
    }

}
