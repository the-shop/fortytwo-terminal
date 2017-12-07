<?php

namespace Framework\Terminal;

use Framework\Base\Application\ApplicationInterface;
use Framework\Terminal\Cron\CronJobInterface;

/**
 * Interface TerminalInterface
 * @package Framework\Terminal
 */
interface TerminalInterface extends ApplicationInterface
{
    /**
     * @return array
     */
    public function getRegisteredCronJobs(): array;

    /**
     * @param CronJobInterface $cronJob
     *
     * @return TerminalInterface
     */
    public function registerCronJob(CronJobInterface $cronJob): TerminalInterface;

    /**
     * @return array
     */
    public function getRegisteredSeeders(): array;

    /**
     * @param string $name
     * @param string $class
     *
     * @return TerminalInterface
     */
    public function registerSeeder(string $name, string $class): TerminalInterface;
}
