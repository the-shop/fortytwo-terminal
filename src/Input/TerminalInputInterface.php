<?php

namespace Framework\Terminal\Input;

use Framework\Base\Application\ApplicationAwareInterface;

/**
 * Interface TerminalInputInterface
 * @package Framework\Base\TerminalApp\Input
 */
interface TerminalInputInterface extends ApplicationAwareInterface
{
    /**
     * @param string $argument
     *
     * @return TerminalInputInterface
     */
    public function setInputCommand(string $argument): TerminalInputInterface;

    /**
     * @return mixed
     */
    public function getInputCommand(): string;

    /**
     * @param array $arguments
     *
     * @return TerminalInputInterface
     */
    public function setInputParameters(array $arguments = []): TerminalInputInterface;

    /**
     * @return array
     */
    public function getInputParameters(): array;
}
