<?php

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    $env = $context['APP_ENV'];

    // this is changes the env to test for the codeception tests
    if (
        isset($_SERVER['HTTP_USER_AGENT'])
        && $_SERVER['HTTP_USER_AGENT'] === 'Codeception PhpBrowser'
    ) {
        $env = 'test';
    }

    return new Kernel($env, (bool)$context['APP_DEBUG']);
};
