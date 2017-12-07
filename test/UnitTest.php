<?php

namespace Framework\Terminal\Test;

use Framework\Base\Application\ApplicationConfiguration;
use Framework\Base\Test\UnitTest as TestCase;

/**
 * Class Test
 * @package Framework\Base\Terminal
 */
class UnitTest extends TestCase
{
    /**
     * UnitTest constructor.
     *
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $appConfig = new ApplicationConfiguration();

        $this->setApplication(new DummyTerminalApp($appConfig));
    }

    /**
     * @param      $testParam
     * @param      $testParam2
     * @param null $optionalParam
     * @param null $optionalParam2
     *
     * @return string
     */
    public function handle($testParam, $testParam2, $optionalParam = null, $optionalParam2 = null)
    {
        return $testParam . ', ' . $testParam2 . ', ' . $optionalParam . ', ' . $optionalParam2;
    }
}
