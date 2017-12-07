<?php

namespace Framework\Terminal\Test;

use Framework\Terminal\Cron\CronJob;

/**
 * Class TestJob
 * @package Framework\Terminal\Test
 */
class TestJob extends CronJob
{
    /**
     * @return array
     */
    public function execute(): array
    {
        return [
            $this->getIdentifier(),
            $this->getCronTimeExpression()
        ];
    }
}
