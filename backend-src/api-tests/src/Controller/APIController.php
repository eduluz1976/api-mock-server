<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Service\RequestService;
use App\Entity\RequestEntity;
use \App\Exception\RequestNotFoundException;
use \App\Exception\InvalidInputException;
use \App\Utils\RequestUtils;


class APIController extends BaseController
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
     * The main endpoint
     *
     * @return void
     */
    public function index(Request $request) {
        $response = new Response();

        $cookie = $request->headers->get('Cookie');

        $origin = RequestUtils::getOriginFromRequest($request);

        $lsRequests = $this->getRequestService()->getAll();

        $lsFinal = [];
        foreach ($lsRequests as $record) {
            if (RequestUtils::match($origin, $record)) {
                $lsFinal[] = $record;
            }
        }

        // TODO: select the most relevant record from list $lsFinal, and operate the next step

        $response->setStatusCode(Response::HTTP_I_AM_A_TEAPOT);

        return $response;
    }

}