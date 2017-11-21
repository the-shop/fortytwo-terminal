<?php

namespace Framework\Terminal;

use Framework\Base\Application\ApplicationConfiguration;
use Framework\Base\Application\BaseApplication;
use Framework\Terminal\Output\TerminalOutput;
use Framework\Terminal\Request\Request;
use Framework\Terminal\Response\Response;
use Framework\Terminal\Router\Dispatcher;
use Framework\Terminal\Cron\CronJobInterface;

/**
 * Class TerminalApplication
 * @package Framework\Terminal
 */
class TerminalApplication extends BaseApplication implements TerminalInterface
{
    /**
     * @var CronJobInterface[]
     */
    protected $registeredCronJobs = [];

    /**
     * Register Seeders in here
     * @var array
     */
    private $seeders = [];

    /**
     * TerminalApplication constructor.
     *
     * @param ApplicationConfiguration|null $applicationConfiguration
     */
    public function __construct(ApplicationConfiguration $applicationConfiguration = null)
    {
        $stream = fopen('php://stdout', 'w');
        $this->setRenderer(new TerminalOutput($stream));
        $this->setDispatcher(new Dispatcher());
        $this->setResponse(new Response());

        parent::__construct($applicationConfiguration);
    }

    public function handle()
    {
        /**
         * @var Dispatcher $dispatcher
         */
        $dispatcher = $this->getDispatcher();
        $handlerPath = $dispatcher->getHandler();

        /**
         * @var \Framework\Terminal\Commands\CommandHandlerInterface $handler
         */
        $handler = new $handlerPath();
        $handler->setApplication($this);
        $parameterValues = array_values($dispatcher->getCommandParameters());
        $handlerOutput = $handler->run($parameterValues);

        $response = $this->getResponse();

        $response->setBody($handlerOutput);

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function buildRequest()
    {
        $request = new Request();
        $request->setServer($_SERVER);

        $this->setRequest($request);

        return $request;
    }

    /**
     * @return CronJobInterface[]|[]
     */
    public function getRegisteredCronJobs(): array
    {
        return $this->registeredCronJobs;
    }

    /**
     * @param \Framework\Terminal\Cron\CronJobInterface $cronJob
     *
     * @return \Framework\Terminal\TerminalInterface
     */
    public function registerCronJob(CronJobInterface $cronJob): TerminalInterface
    {
        $this->registeredCronJobs[] = $cronJob;

        return $this;
    }

    /**
     * @return array
     */
    public function getRegisteredSeeders(): array
    {
        return $this->seeders;
    }

    /**
     * @param string $seederName
     * @param string $fullyQualifiedClassPath
     * @return \Framework\Terminal\TerminalInterface
     */
    public function registerSeeder(string $seederName, string $fullyQualifiedClassPath): TerminalInterface
    {
        $this->seeders[$seederName] = $fullyQualifiedClassPath;

        return $this;
    }
}
