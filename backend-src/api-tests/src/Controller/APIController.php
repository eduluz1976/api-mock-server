<?php

namespace App\Controller;

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

class APIController extends BaseController
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
    protected function getRequestService(): RequestService
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


    /**
     * The main endpoint
     *
     * @return void
     */
    public function index(Request $currentRequest)
    {
        $response = new Response();
        $httpStatusCodeResponse = Response::HTTP_I_AM_A_TEAPOT;
        $contentResponse = '';

        // $response->setStatusCode(Response::HTTP_I_AM_A_TEAPOT);


        $cookie = $currentRequest->headers->get('Cookie');

        $origin = RequestUtils::getOriginFromRequest($currentRequest);

        $lsRequests = $this->getRequestService()->getAll();

        $lsFinal = [];
        foreach ($lsRequests as $record) {
            if (RequestUtils::match($origin, $record)) {
                if ($record->getStatus() !== 'done') {
                    $lsFinal[] = $record;
                }
            }
        }



        $selectedRecord = reset($lsFinal);

        if ($selectedRecord) {
            $transaction = $this->getTransactionService()->getOrElseCreate($selectedRecord->getTransactionId());

            // Get the next step

            if ($transaction->hasAvailableNextStep()) {

                // Execute the process

                $indexStep = $transaction->getNextIndexStep();
                $lsSteps = $transaction->getSteps();

                if ($indexStep === 0) {
                    $selectedRecord->setStatus('running');
                }

                $currentStep = $lsSteps[$indexStep];

                // ----
                // Execute the current step
                // -----




                $currentStepRequest = $currentStep['request'];
                $currentStepResponse = $currentStep['response'];

                // echo '<pre>';
                // print_r([

                //     $currentStepRequest['url'] , $currentRequest->getPathInfo()
                //     ,$currentStepRequest['method'] , $currentRequest->getMethod()

                // ]);
                // exit;


                if ($currentStepRequest['url'] === $currentRequest->getPathInfo()
                    && $currentStepRequest['method'] === $currentRequest->getMethod()) {
                    $httpStatusCodeResponse = $currentStepResponse['httpStatusCode'] ?? Response::HTTP_OK;
                    $contentResponse = $currentStepResponse['json'] ?? '';


                    //     $response->setContent(json_encode([
                    //     'uri' => $currentRequest->getUri(),
                    //     'baseUrl' => $currentRequest->getBaseUrl(),
                    //     'method' => $currentRequest->getMethod(),
                    //     'getQueryString' => $currentRequest->getQueryString(),
                    //     'getPathInfo' => $currentRequest->getPathInfo(),
                    //     'getRequestUri' => $currentRequest->getRequestUri(),
                    // ]));

                    //



                    // -----
                    // -----
                }


                $executionResult = [
                    'input' => [
                        'method' => $currentRequest->getMethod(),
                        'url' => $currentRequest->getPathInfo(),
                        'contents' => $currentRequest->getContent(),
                        'headers' => $currentRequest->headers->all(),
                    ],
                    'output' => [
                        'httpCode' => $httpStatusCodeResponse,
                        'contents' => $contentResponse
                    ],
                ];

                $lsSteps[$indexStep]['logs'] = $executionResult;




                $transaction->setSteps($lsSteps);

                $transaction->incrementNextIndexStep();

                if (!$transaction->hasAvailableNextStep()) {
                    $selectedRecord->setStatus('done');
                }

                $this->getRequestService()->update($selectedRecord);

                $this->getTransactionService()->update($transaction);


                // if ($currentStep[''])
            }




            // echo '<pre>';
            // print_r($transaction);
            // print_r($selectedRecord);

            // exit;
        }

        $response->setStatusCode($httpStatusCodeResponse);
        $response->setContent($contentResponse);


        // TODO: select the most relevant record from list $lsFinal, and operate the next step
        // $selectedRecord = reset($lsFinal);
        // if ($selectedRecord) {

        //     $transaction = $this->getTransactionService()->get($selectedRecord)



        // }





        return $response;
    }
}
