<?php

use App\Kernel;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

    return function (array $context) {
        return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
    };
} catch (Exception $ex) {
    echo $ex->getMessage();
} 


