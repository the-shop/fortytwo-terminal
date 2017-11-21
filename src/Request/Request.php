<?php

namespace Framework\Terminal\Request;

use Framework\Base\Request\Request as BaseRequest;
use Framework\Base\Request\RequestInterface;

/**
 * Class Request
 * @package Framework\Terminal\Request
 */
class Request extends BaseRequest implements TerminalRequestInterface
{
    /**
     * @var array
     */
    private $serverInformation = [];

    private $method = 'GET';

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return \Framework\Terminal\Request\TerminalRequestInterface
     */
    public function setMethod(string $method): TerminalRequestInterface
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->serverInformation;
    }

    /**
     * @param array $serverInformationMap
     * @return \Framework\Terminal\Request\TerminalRequestInterface
     */
    public function setServer(array $serverInformationMap = []): TerminalRequestInterface
    {
        $this->serverInformation = $serverInformationMap;

        $requestMethod = isset($serverInformationMap['REQUEST_METHOD']) === true
            ? strtoupper($serverInformationMap['REQUEST_METHOD']) : 'GET';

        $this->setMethod($requestMethod);

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return \Framework\Base\Request\RequestInterface
     */
    public function setUri(string $uri): RequestInterface
    {
        // Normalize $uri, prepend with slash if not there
        if (strlen($uri) > 0 && $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        // Strip query string (?foo=bar)
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        parent::setUri($uri);

        return $this;
    }
}
