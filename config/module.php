<?php

use Framework\Base\Application\BaseApplication;
use Framework\Base\Application\Exception\ExceptionHandler;
use Framework\Terminal\Commands\CronJobsScheduler;
use Framework\Terminal\Commands\DatabaseSeedersHandler;
use Framework\Terminal\Commands\QueueWorker;
use Framework\Terminal\Listeners\ExceptionFormatter;
use Framework\Terminal\Listeners\ResponseFormatter;

return [
    'commands' => [
        'cron:job' => [
            'handler' => CronJobsScheduler::class,
            'requiredParams' => [],
            'optionalParams' => [],
        ],
        'queue:worker' => [
            'handler' => QueueWorker::class,
            'requiredParams' => [],
            'optionalParams' => [],
        ],
        'db:seed' => [
            'handler' => DatabaseSeedersHandler::class,
            'requiredParams' => [
                'seederName'
            ],
            'optionalParams' => [],
        ]
    ],
    'listeners' => [
        BaseApplication::EVENT_APPLICATION_RENDER_RESPONSE_PRE => [
            ResponseFormatter::class,
        ],
        ExceptionHandler::EVENT_EXCEPTION_HANDLER_HANDLE_PRE => [
            ExceptionFormatter::class,
        ]
    ],
    'cronJobs' => [],
    'queueNames' => [],
    'seeders' => [],
];
