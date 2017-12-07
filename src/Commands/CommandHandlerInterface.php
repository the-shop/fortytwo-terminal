<?php

namespace Framework\Terminal\Commands;

use Framework\Base\Application\ApplicationAwareInterface;

/**
 * Interface CommandHandlerInterface
 * @package Framework\Terminal\Commands
 */
interface CommandHandlerInterface extends ApplicationAwareInterface
{
    /**
     * @param array $parameterValues
     *
     * @return mixed
     */
    public function run(array $parameterValues = []);
}
