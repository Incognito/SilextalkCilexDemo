<?php

require_once __DIR__.'/vendor/autoload.php';

use Incognito\SilextalkCilexDemo\Command\ComposeCommand;

$app = new \Cilex\Application('CilexMailer');
$app->command(new ComposeCommand());

$app->run();
