<?php

include_once __DIR__ . '/Commons.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use \App\lib\DataRepository;
use \App\Constants;

class RequestsTest extends Commons
{


    protected function getRequestedData() {
        $request = [
            'steps' => [
                [
                    'request' => [
                        'method' => 'GET',
                        'url' => '/url_configured'
                    ],
                    'response' => [
                        'code' => 200,
                        'contents' => [
                            'text' => 'Ok, it worked!'
                        ]
                    ]
                ]
            ]
        ];
        return $request;
    }



    /** 
     * @test 
     * @depends test_configuring_request_on_admin_should_return_transactionId
     * */
    public function test_requesting_a_non_existent_request_on_admin_should_return_error_404()
    {
        $transactionId = '5db4b9905f510d856c67920c3a74eec5faa0fb1e3eaa3e7de2217ef96955a66a';

        try {
            $response = $this->getAdmin()->request('GET', "/request/$transactionId");
            $this->assertTrue(false,'Error 404 was not caught');
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $this->assertEquals(404, $ex->getResponse()->getStatusCode());

            $arr = json_decode($ex->getResponse()->getBody()->getContents(), true);
            $this->assertTrue(is_array($arr));
            $this->assertArrayHasKey('msg', $arr);
            $this->assertEquals("Request with id $transactionId was not found", $arr['msg']);
        }

    }

    /** 
     * @test 
     * @depends test_configuring_request_on_admin_should_return_transactionId
     * */
    public function test_requesting_with_an_invalid_transactionId_should_return_error_400()
    {
        $transactionId = 'invalid_transactionId';

        try {
            $response = $this->getAdmin()->request('GET', "/request/$transactionId");
            $this->assertTrue(false,'Error 400 was not caught');
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $this->assertEquals(400, $ex->getResponse()->getStatusCode());

            $arr = json_decode($ex->getResponse()->getBody()->getContents(), true);
            $this->assertTrue(is_array($arr));
            $this->assertArrayHasKey('msg', $arr);
            $this->assertEquals("Invalid transactionId", $arr['msg']);
        }

    }


    /** @test */
    public function test_configuring_request_on_admin_should_return_transactionId()
    {

        $requestData = $this->getRequestedData();

        $response = $this->getAdmin()->request('POST', '/request',[
            'json' => $requestData
        ]);
        $this->assertEquals(201, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertTrue(is_array($json));
        $this->assertArrayHasKey(Constants::RESPONSE_TRANSACTION_ID, $json);
        

        $this->getRepository()->addItem(Constants::RESPONSE_TRANSACTION_ID, $json[Constants::RESPONSE_TRANSACTION_ID]);
        $this->getRepository()->addItem(Constants::RESPONSE_TRANSACTION, $json);
    }
    
    /** 
     * @test 
     * @depends test_configuring_request_on_admin_should_return_transactionId
     * */
    public function test_requesting_a_configured_request_on_admin_should_return_the_transaction_information()
    {
        $transactionId = $this->getRepository()->getItem(Constants::RESPONSE_TRANSACTION_ID);
        $this->assertEquals(64, strlen($transactionId));

        $response = $this->getAdmin()->request('GET', "/request/$transactionId");

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertTrue(is_array($json));
        $this->assertArrayHasKey(Constants::RESPONSE_TRANSACTION_ID, $json);
        $this->assertEquals($transactionId, $json[Constants::RESPONSE_TRANSACTION_ID]);
        $this->assertArrayHasKey('status', $json);
        $this->assertEquals('pending', $json['status']);

    }
    
        
}
