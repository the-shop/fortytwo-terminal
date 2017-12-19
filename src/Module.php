<?php

namespace Framework\Terminal;

use Framework\Base\Module\BaseModule;

/**
 * Class Module
 * @package Framework\Base\Terminal
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public function loadConfig()
    {
        // Let's read all files from module config folder and set to Configuration
        $configDirPath = realpath(dirname(__DIR__)) . '/config/';
        $this->setModuleConfiguration($configDirPath);
    }

    /**
     * @inheritdoc
     */
    public function bootstrap()
    {
        /** @var \Framework\Terminal\TerminalInterface $application */
        $application = $this->getApplication();
        $appConfig = $application->getConfiguration();

        // Add commands to dispatcher
        $application->getDispatcher()
                    ->addRoutes($appConfig->getPathValue('commands'));

        // Register cron jobs
        $cronJobs = $appConfig->getPathValue('cronJobs');
        foreach ($cronJobs as $job => $params) {
            $cronJob = new $job($params);
            $application->registerCronJob($cronJob);
        }

        // Register database seeders
        $seeders = $appConfig->getPathValue('seeders');
        foreach ($seeders as $name => $class) {
            $application->registerSeeder($name, $class);
        }
    }
}
