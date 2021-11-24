<?php

use Service\App;

require __DIR__ . '/src/autoload.php';

/** @var array $config */
$app = App::getInstance($config);
$app->router()->process()->go()->display();