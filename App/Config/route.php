<?php

use Supermetrics\App\Controller\Controller;

return [
    '/' => [
        'controller' => Controller::class,
        'action' => 'welcome',
    ],
    '/statistics' => [
        'controller' => Controller::class,
        'action' => 'statistics',
    ],
];