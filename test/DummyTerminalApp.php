<?php

namespace Framework\Terminal\Test;

use Framework\Base\Application\ApplicationConfiguration;
use Framework\Base\Test\Dummies\DummyRequest;
use Framework\Base\Test\Dummies\DummyResponse;
use Framework\Terminal\TerminalApplication;

class DummyTerminalApp extends TerminalApplication
{
    public function __construct(ApplicationConfiguration $applicationConfiguration = null)
    {
        $this->setResponse(new DummyResponse());

        parent::__construct($applicationConfiguration);
    }

    public function buildRequest()
    {
        $request = new DummyRequest();

        $this->setRequest($request);

        return $request;
    }
}
