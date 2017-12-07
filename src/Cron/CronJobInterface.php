<?php

namespace Framework\Terminal\Cron;

use Framework\Base\Application\ApplicationAwareInterface;

/**
 * Interface CronJobInterface
 * @package Framework\Terminal\Commands\Cron
 */
interface CronJobInterface extends ApplicationAwareInterface
{
    /**
     * CronJobInterface constructor.
     *
     * @param array $cronJobParams
     */
    public function __construct(array $cronJobParams);

    /**
     * @param string $expression
     *
     * @return CronJobInterface
     */
    public function setCronTimeExpression(string $expression): CronJobInterface;

    /**
     * @return string
     */
    public function getCronTimeExpression(): string;

    /**
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * @param array $args
     *
     * @return CronJobInterface
     */
    public function setArgs(array $args): CronJobInterface;

    /**
     * @return array
     */
    public function getArgs(): array;

    /**
     * @return mixed
     */
    public function execute();
}
