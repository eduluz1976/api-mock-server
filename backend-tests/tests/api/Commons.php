<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use \App\lib\DataRepository;
use \App\Constants;

class Commons extends TestCase
{

    protected $client;
    protected $admin;

    protected static $repository;


    protected function getClient() {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => 'http://nginx:8080',
            ]);
        }

        return $this->client;
    }

    protected function getAdmin() {
        if (!$this->admin) {
            $this->admin = new Client([
                'base_uri' => 'http://nginx:8081',
            ]);
        }

        return $this->admin;
    }

    protected function getRepository() : DataRepository{
        if (!self::$repository) {
            self::$repository = new DataRepository();
        }
        return self::$repository;
    }

    
        
}
