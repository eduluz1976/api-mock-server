<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HealthController extends AbstractController
{
    /**
     * @Route("/health")
     */
    public function health()
    {
        return new Response('OK');
    }

}