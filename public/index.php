<?php

require_once __DIR__ . '/../vendor/autoload.php';
$controller = new \App\Controllers\PatioController();
$controller->entrada();
$controller->index();
