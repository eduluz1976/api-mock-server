<?php

namespace App\Utils;



class RequestUtils {



    public static function getOriginFromRequest($request) {
        $res = [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'hash-cookie' => self::hash($request->headers->get('Cookie'))
        ];

        return $res;
    }


    public static function match($currOrigin, $requestRecord) {


        $recordOrigin = $requestRecord->getOrigin();
        $recordSelector = $requestRecord->getSelector();

        $hashCookie = $recordOrigin['hash-cookie'] ?? null;

        if (($recordOrigin['ip'] === $currOrigin['ip']) 
                && ($hashCookie === $currOrigin['hash-cookie'])
                ) {
                    return true;
                }


        // if ($recordSelector['condition'] === 'match-all') {

        // }



        return false;
    }



    public static function hash($value) {
        return \hash('sha256', $value);
    }
    

}