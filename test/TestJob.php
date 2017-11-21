<?php

namespace Framework\Terminal\Test;

use Framework\Terminal\Cron\CronJob;

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
