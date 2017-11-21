<?php

namespace Framework\Terminal\Request;

use Framework\Base\Request\RequestInterface;

/**
 * Interface TerminalRequestInterface
 * @package Framework\Terminal\Request
 */
interface TerminalRequestInterface extends RequestInterface
{
    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param string $method
     *
     * @return \Framework\Terminal\Request\TerminalRequestInterface
     */
    public function setMethod(string $method): TerminalRequestInterface;

    /**
     * @return array
     */
    public function getServer(): array;

    /**
     * @param array $serverInfo
     *
     * @return \Framework\Terminal\Request\TerminalRequestInterface
     */
    public function setServer(array $serverInfo): TerminalRequestInterface;
}
