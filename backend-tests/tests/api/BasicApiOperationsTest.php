<?php

include_once __DIR__ . '/Commons.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use \App\lib\DataRepository;
use \App\Constants;

class BasicApiOperationsTest extends Commons
{


    /** @test */
    public function test_non_configured_request_should_return_error_418()
    {
        try {
            $response = $this->getClient()->request('GET', '/unknown');
            $this->assertTrue(false);
        } catch (Exception $ex) {            
            $this->assertTrue(true);            
            $this->assertEquals(418, $ex->getResponse()->getStatusCode());
        }
    }


}
