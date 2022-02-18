<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseController
{
    /**
     *
     *
     * @Route("/")
     */
    public function index()
    {
        return new Response("<h1>Welcome to ASM-UI</h1>");
    }
}
