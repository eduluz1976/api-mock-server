<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Service\RequestService;
use App\Service\TransactionService;
use App\Entity\RequestEntity;
use App\Entity\TransactionEntity;

use App\Exception\RequestNotFoundException;
use App\Exception\InvalidInputException;
use App\Utils\RequestUtils;

class RequestController extends BaseController
{
    /**
     * @var RequestService
     */
    protected $requestService;

    /**
     * @var TransactionService
     */
    protected $transactionService;



    /**
     * DI: RequestService provider
     *
     * @return RequestService
     */
    protected function getRequestService()
    {
        if (!$this->requestService) {
            $this->requestService = new RequestService();
        }
        return $this->requestService;
    }


    /**
     * DI: TransactionService provider
     *
     * @return TransactionService
     */
    protected function getTransactionService(): TransactionService
    {
        if (!$this->transactionService) {
            $this->transactionService = new TransactionService();
        }
        return $this->transactionService;
    }

    protected function getAdditionalRequestFields($request)
    {
        $res = [];

        $res['origin'] =  RequestUtils::getOriginFromRequest($request);

        $res['selector'] = [
            'condition' => 'match-all'
        ];

        return $res;
    }

    protected function hash($value)
    {
        return \hash('sha256', $value);
    }


    /**
     *
     * @Route("/request")
     */
    public function addNewRequest(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $response = new Response();

        if (!$payload) {
            $response->setContent(json_encode(['msg' => 'Invalid input']));
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $requestEntity = new RequestEntity();

            $payload = array_merge($payload, $this->getAdditionalRequestFields($request));


            $requestEntity->import($payload);


            $transactionId = $this->getRequestService()->save($requestEntity);

            $aResponse = [
                'transactionId' => $transactionId,
                'request' => $requestEntity->toArray()
            ];

            $sResponse = json_encode($aResponse, true);
            $response->setContent($sResponse);
            $response->setStatusCode(Response::HTTP_CREATED);
        }

        return $response;
    }


    /**
     *
     *
     * @Route("/request/{transactionId}")
     */
    public function getRequest($transactionId)
    {
        try {
            $responseVO = $this->getRequestService()->get($transactionId);
            $response = $responseVO->toArray();
            return $this->json($response);
        } catch (RequestNotFoundException $ex) {
            $response = new Response();
            $response->setContent(json_encode(['msg' => $ex->getMessage()]));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            return $response;
        } catch (InvalidInputException $ex) {
            $response = new Response();
            $response->setContent(json_encode(['msg' => $ex->getMessage()]));
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response;
        }
    }

    /**
     *
     *
     * @Route("/request/{transactionId}/report")
     */
    public function getRequestWithTransaction($transactionId)
    {
        $response = new Response();
        $requestEntity = new RequestEntity();
        $transactionEntity = new TransactionEntity();
        $preparedResponse = [ ];

        try {
            $requestEntity = $this->getRequestService()->get($transactionId);

            $preparedResponse['request'] = $requestEntity->toArray();

            // $transactionEntity = $this->getTransactionService($transactionId);




            //return $this->json($response);
        } catch (RequestNotFoundException $ex) {
            // $response = new Response();
            $preparedResponse['msg'] =  $ex->getMessage();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            return $response;
        } catch (InvalidInputException $ex) {
            $preparedResponse['msg'] =  $ex->getMessage();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }


        try {
            $transactionEntity = $this->getTransactionService()->get($transactionId);
            $preparedResponse['transaction'] = $transactionEntity->toArray();
        } catch (\Exception $ex) {
            //
        }

        $response->setContent(\json_encode($preparedResponse, JSON_PRETTY_PRINT));
        //  = [
        //     'request' => $requestEntity->toArray()
        // ];


        return $response;
    }
}
