<?php

namespace Framework\Terminal\Test;

use Framework\Base\Application\ApplicationConfigurationInterface;
use Framework\Base\Test\Dummies\DummyRequest;
use Framework\Base\Test\Dummies\DummyResponse;
use Framework\Terminal\TerminalApplication;

/**
 * Class DummyTerminalApp
 * @package Framework\Terminal\Test
 */
class DummyTerminalApp extends TerminalApplication
{
    /**
     * DummyTerminalApp constructor.
     *
     * @param ApplicationConfigurationInterface|null $applicationConfiguration
     */
    public function __construct(ApplicationConfigurationInterface $applicationConfiguration = null)
    {
        $this->setResponse(new DummyResponse());

        parent::__construct($applicationConfiguration);
    }

    /**
     * @return DummyRequest
     */
    public function buildRequest()
    {
        $request = new DummyRequest();

        $this->setRequest($request);

        return $request;
    }
}
