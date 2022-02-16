<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Service\RequestService;
use App\Entity\RequestEntity;
use \App\Exception\RequestNotFoundException;
use \App\Exception\InvalidInputException;

class RequestController extends AbstractController
{

    
    /**
     * @var RequestService
     */
    protected $requestService;



    /**
     * DI: RequestService provider 
     *
     * @return RequestService
     */
    protected function getRequestService() {
        if (!$this->requestService) {
            $this->requestService = new RequestService();
        }
        return $this->requestService;
    }
    

    /**
     *
     * @Route("/request")
     */
    public function addNewRequest(Request $request) {
        $payload = json_decode($request->getContent(), true);

        $response = new Response();

        if (!$payload) {
            $response->setContent(json_encode(['msg' => 'Invalid input']));
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);            
        } else {
            $requestEntity = new RequestEntity();
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
    public function getRequest($transactionId) {

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

}