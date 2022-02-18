<?php

namespace App\Service;

use App\Constants;
use App\Entity\RequestEntity;
use App\Factory\RequestFactory;
use App\Exception\RequestNotFoundException;
use App\Exception\InvalidInputException;
use App\Utils\RequestUtils;

class RequestService extends BaseService
{
    public const TYPE = 'request';

    protected function getKey($transactionId): string
    {
        return 'request:'.$transactionId;
    }



    public function save($request)
    {
        $transactionId = hash('sha256', time());

        $request = $this->setFieldsToSave($request, $transactionId);

        $this->getRedisClient()->hSet(self::TYPE, $this->getKey($transactionId), $request->export());

        return $transactionId;
    }


    protected function setFieldsToSave($request, $transactionId)
    {
        $request->setTransactionId($transactionId);
        $request->setStatus(Constants::REQUEST_STATUS_PENDING);
        return $request;
    }



    /**
     * Return a given Request
     *
     * @param string $transactionId
     * @return RequestEntity
     */
    public function get($transactionId): RequestEntity
    {
        $this->validateTransactionId($transactionId);


        $data = $this->getRedisClient()->hget(self::TYPE, $this->getKey($transactionId));

        if (!$data) {
            throw new RequestNotFoundException("Request with id $transactionId was not found");
        }

        $request = RequestFactory::makeEntity($data);

        return $request;
    }



    /**
     *
     * @return array
     */
    public function getAll(): array
    {
        $ls = $this->getRedisClient()->hGetAll('request');

        $requests = [];

        foreach ($ls as $transactionId => $requestArr) {
            $request = RequestFactory::makeEntity($requestArr);


            $requests[] = $request;
        }

        return $requests;
    }

    public function update(RequestEntity $requestEntity)
    {
        $transactionId = $requestEntity->getTransactionId();
        $result = $this->getRedisClient()->hset(self::TYPE, $this->getKey($transactionId), $requestEntity->export());
        if (false === $result) {
            throw new \Exception("Error updating request $transactionId");
        }
    }
}
