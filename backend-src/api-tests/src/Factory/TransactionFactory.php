<?php

namespace App\Factory;

use \App\Entity\TransactionEntity;

class TransactionFactory {

    public static function makeEntity($data) {

        $transactionEntity = new TransactionEntity();

        switch (gettype($data)) {

            case 'array':
                $transactionEntity->import($data);
                break;
            case 'string':
                $arr = \json_decode($data, true);
                $transactionEntity->import($arr);
                break;
            case 'object':

                // echo "\n" . get_class($data) . "<hr>";
                if (get_class($data) === 'App\Entity\RequestEntity') {
                    $arr = [
                        'transactionId' => $data->getTransactionId(),
                        'steps' => $data->getSteps(),
                    ];
                    $transactionEntity->import($arr);
                }
                break;
        }

        return $transactionEntity;

    }

}