<?php

namespace Framework\Terminal\Output;

use Framework\Base\Application\ApplicationAwareInterface;
use Framework\Base\Render\RenderInterface;

/**
 * Interface TerminalOutputInterface
 * @package Framework\Base\TerminalApp\Output
 */
interface TerminalOutputInterface extends RenderInterface, ApplicationAwareInterface
{
    /**
     * @return TerminalOutputInterface
     */
    public function outputMessages(): TerminalOutputInterface;

    /**
     * @param string $message
     * @param bool   $newline
     *
     * @return TerminalOutputInterface
     */
    public function writeOutput(string $message, bool $newline = false): TerminalOutputInterface;

    /**
     * @param array $messages
     *
     * @return TerminalOutputInterface
     */
    public function setOutputMessages(array $messages = []): TerminalOutputInterface;

    /**
     * @return array
     */
    public function getOutputMessages(): array;

    /**
     * @param $stream
     *
     * @return TerminalOutputInterface
     */
    public function setOutputStream($stream): TerminalOutputInterface;

    /**
     * @return mixed
     */
    public function getOutputStream();

    /**
     * @return ColorFormatter
     */
    public function getColorFormatter();

    /**
     * @param ColorFormatter $formatter
     *
     * @return TerminalOutputInterface
     */
    public function setColorFormatter(ColorFormatter $formatter): TerminalOutputInterface;
}
