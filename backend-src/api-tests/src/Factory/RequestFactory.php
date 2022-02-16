<?php

namespace App\Factory;

use \App\Entity\RequestEntity;

class RequestFactory {


    public static function makeEntity($data) {

        $requestEntity = new RequestEntity();

        switch (gettype($data)) {

            case 'array':
                $requestEntity->import($data);
                break;
            case 'string':
                $arr = \json_decode($data, true);
                $requestEntity->import($arr);
                break;

        }

        return $requestEntity;

    }


}