<?php

require_once realpath('./vendor/autoload.php');

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(realpath('./.env'));

$appConfig = new \Framework\Base\Application\ApplicationConfiguration();
$appConfig->setRegisteredModules([
    \Framework\Base\Module::class,
    \Framework\Terminal\Module::class
]);

$app = new \Framework\Terminal\TerminalApplication($appConfig);

try {
    $app->run();
} catch (\Exception $e) {
    $app->getExceptionHandler()
        ->handle($e);

    $app->getRenderer()
        ->render($app->getResponse());
}
