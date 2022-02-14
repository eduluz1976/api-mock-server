<?php

include_once __DIR__ .'/../bootstrap.php';

if ($_SERVER['X_CONTAINER'] === 'api-admin') {
    include_once __DIR__ . '/admin/index.php';
    return;
}

include_once __DIR__ . '/default/index.php';
