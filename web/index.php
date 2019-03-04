<?php

const DS = DIRECTORY_SEPARATOR;

require_once __DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use Supermetrics\Kernel\Kernel;

$request = ServerRequest::fromGlobals();

$configDirectory = __DIR__ . DS . '..' . DS . 'App' . DS . 'Config';
$kernel = new Kernel($configDirectory);
$kernel->processRequest($request);