<?php

namespace Framework\Terminal\Output;

use Framework\Base\Application\ApplicationAwareTrait;
use Framework\Base\Response\ResponseInterface;

/**
 * Class TerminalOutput
 * @package Framework\Base\TerminalApp\Output
 */
class TerminalOutput implements TerminalOutputInterface
{
    use ApplicationAwareTrait;

    /**
     * @var array
     */
    private $outputMessages = [];

    /**
     * @var
     */
    private $stream;

    /**
     * @var ColorFormatter
     */
    private $colorFormatter;

    /**
     * TerminalOutput constructor.
     *
     * @param $stream
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($stream)
    {
        if (is_resource($stream) === false || ('stream' === get_resource_type($stream)) === false) {
            throw new \InvalidArgumentException('The TerminalOutput class needs a stream as its first argument.', 404);
        }

        $this->setColorFormatter(new ColorFormatter())
             ->setOutputStream($stream);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return TerminalOutputInterface
     */
    public function render(ResponseInterface $response): TerminalOutputInterface
    {
        $responseCode = $response->getCode();
        $responseBody = $response->getBody();

        if (is_array($responseBody) === true) {
            $responseBody = $this->arrayToString($responseBody);
        }

        $foregroundColor = 'green';
        $backgroundColor = 'black';
        $colorFormatter = $this->getColorFormatter();

        $statusMessage = 'Status code: ' . $responseCode;

        if ($responseCode === 0) {
            $statusMessage .= ' command DONE!';
            $responseMessage =
                $colorFormatter->getColoredString(
                    'Response: ',
                    $foregroundColor,
                    $backgroundColor
                )
                . $responseBody;
        } else {
            $statusMessage .= ' command FAILED!';
            $foregroundColor = 'red';
            $backgroundColor = 'light_gray';
            $responseMessage =
                $colorFormatter->getColoredString(
                    'Response: '
                    . $responseBody,
                    $foregroundColor,
                    $backgroundColor
                );
        }

        $codeMsg = $colorFormatter->getColoredString(
            $statusMessage,
            $foregroundColor,
            $backgroundColor
        );

        $this->setOutputMessages(
            [
                $codeMsg,
                $responseMessage,
            ]
        );

        $this->outputMessages();

        return $this;
    }

    private function arrayToString(array $array)
    {
        $output = '';

        foreach ($array as $key => $value) {
            if (is_int($key) === false) {
                $output .= "$key => ";
            }

            if (is_array($value) === true) {
                $output .= $this->arrayToString($value);
            } elseif (is_bool($value) === true) {
                $output .= $value ? "true\n" : "false\n";
            } elseif (is_null($value) === true) {
                $output .= "null\n";
            } else {
                $output .= "$value\n";
            }
        }

        return $output;
    }

    /**
     * @return ColorFormatter
     */
    public function getColorFormatter()
    {
        return $this->colorFormatter;
    }

    /**
     * @param ColorFormatter $colorFormatter
     *
     * @return TerminalOutputInterface
     */
    public function setColorFormatter(ColorFormatter $colorFormatter): TerminalOutputInterface
    {
        $this->colorFormatter = $colorFormatter;

        return $this;
    }

    /**
     * @return TerminalOutputInterface
     */
    public function outputMessages(): TerminalOutputInterface
    {
        $messages = $this->getOutputMessages();

        foreach ($messages as $message) {
            $this->writeOutput($message, true);
        }

        $this->closeOutputStream();

        return $this;
    }

    /**
     * @return array
     */
    public function getOutputMessages(): array
    {
        return $this->outputMessages;
    }

    /**
     * @param array $messages
     *
     * @return TerminalOutputInterface
     */
    public function setOutputMessages(array $messages = []): TerminalOutputInterface
    {
        $this->outputMessages = $messages;

        return $this;
    }

    /**
     * @param string $message
     * @param bool   $newline
     *
     * @return TerminalOutputInterface
     * @throws \RuntimeException
     */
    public function writeOutput(string $message, bool $newline = false): TerminalOutputInterface
    {
        if (fwrite($this->stream, $message) === false
            || (
                   $newline
                   && (fwrite($this->stream, PHP_EOL))
               ) === false
        ) {
            throw new \RuntimeException('Unable to write output.');
        }

        return $this;
    }

    /**
     * @return TerminalOutputInterface
     */
    private function closeOutputStream(): TerminalOutputInterface
    {
        $stream = $this->getOutputStream();

        fclose($stream);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutputStream()
    {
        return $this->stream;
    }

    /**
     * @param $stream
     *
     * @return TerminalOutputInterface
     */
    public function setOutputStream($stream): TerminalOutputInterface
    {
        $this->stream = $stream;

        return $this;
    }
}
