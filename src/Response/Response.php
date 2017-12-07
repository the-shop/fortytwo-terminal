<?php

namespace Framework\Terminal\Response;

use Framework\Base\Response\Response as BaseResponse;

/**
 * Class Response
 * @package Framework\Terminal\Response
 */
class Response extends BaseResponse implements TerminalResponseInterface
{
    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->setCode(0);
    }
}
