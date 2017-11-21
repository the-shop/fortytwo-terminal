<?php

namespace Framework\Terminal\Seeder;

use Framework\Base\Application\ApplicationAwareInterface;

/**
 * Interface SeederInterface
 * @package Framework\Terminal\Seeder
 */
interface SeederInterface extends ApplicationAwareInterface
{
    /**
     * @return mixed
     */
    public function seed();
}
