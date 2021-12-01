<?php

use Service\App;

if (!defined('STDIN'))
{
    exit();
}

if (!file_exists('vendor/autoload.php'))
{
    exit('Dependencies Not Installed – Run "composer install"');
}

require_once 'src/autoload.php';

/** @var array $config */
if (!$config['installLock']) {
    $requestType = '';
    while (!in_array($requestType, ['install', 'uninstall', 'reinstall', 'cancel']))
    {
        $requestType = trim(strtolower(readline('Select Operation [install|uninstall|reinstall|cancel]: ')));
    }

    $app = App::getInstance($config);

    $setup = new Service\Setup($app);
    switch ($requestType)
    {
        case 'install':
            $setup->runSetup();
            break;
        case 'uninstall':
            $setup->runUninstall();
            break;
        case 'reinstall':
            $setup->runUninstall();
            $setup->runSetup();
            break;
        default:
            echo 'Cancelled Operation';
    }

    echo PHP_EOL . 'Done!' . PHP_EOL;
}