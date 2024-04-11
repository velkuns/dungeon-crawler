<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Eureka\Kernel\Http\Application\Application;
use Eureka\Kernel\Http\Kernel;

session_start();

//~ Define Loader & add main classes for config
require_once __DIR__ . '/../vendor/autoload.php';

$root  = realpath(__DIR__ . '/..');
$env   = getenv('EKA_ENV') ?: 'prod';
$debug = (bool) (getenv('EKA_DEBUG') ?: ($env === 'dev'));

//~ Run application
try {
    $application = new Application(new Kernel($root, $env, $debug));
    $application->send($application->run());
} catch (\Exception $exception) {
    if ($env !== 'prod' || $debug === true) {
        echo 'Exception: ' . $exception->getMessage() . PHP_EOL;
        echo 'Trace: ' . $exception->getTraceAsString() . PHP_EOL;
    }
    exit(1);
}
