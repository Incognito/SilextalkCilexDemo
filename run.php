<?php

require_once __DIR__.'/vendor/autoload.php';

use Incognito\SilextalkCilexDemo\SilextalkCilexDemoServiceRegistry;

$app = new \Cilex\Application('CilexMailer');

SilextalkCilexDemoServiceRegistry::boot($app);

$app->command($app['mailer.command']);

$app->run();
