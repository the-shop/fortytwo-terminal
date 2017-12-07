<?php

namespace Framework\Terminal\Cron;

use Framework\Base\Application\ApplicationAwareTrait;

/**
 * Class CronJob
 * @package Framework\Terminal\Cron
 */
abstract class CronJob implements CronJobInterface
{
    use ApplicationAwareTrait;

    /**
     * @var string
     */
    private $cronTimeExpression = '0 0 * * 0';

    /**
     * @var array
     */
    private $args = [];

    /**
     * CronJob constructor.
     *
     * @param array $cronJobParams
     */
    public function __construct(array $cronJobParams)
    {
        if (is_array($cronJobParams['timer'])) {
            list($method, $args) = $cronJobParams['timer'];
            if (method_exists($this, $method) === true) {
                $this->{$method}(...$args);
            }
        } elseif (method_exists($this, $cronJobParams['timer']) === true) {
            $this->{$cronJobParams['timer']}();
        } else {
            $this->setCronTimeExpression($cronJobParams['timer']);
        }
        $this->setArgs($cronJobParams['args']);
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return get_class($this);
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     *
     * @return CronJobInterface
     */
    public function setArgs(array $args): CronJobInterface
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Get the cronTimeExpression expression for the event.
     * @return string
     */
    public function getCronTimeExpression(): string
    {
        return $this->cronTimeExpression;
    }

    /**
     * Set the cronTimeExpression expression for the event.
     *
     * @param string $expression
     *
     * @return CronJobInterface
     */
    public function setCronTimeExpression(string $expression): CronJobInterface
    {
        $this->cronTimeExpression = $expression;

        return $this;
    }

    /**
     * @param $input
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public function formatUnixTimeStamp($input): int
    {
        if (strlen((string)$input) === 10) {
            return (int)$input;
        } elseif (strlen((string)$input) === 13) {
            return (int)substr((string)$input, 0, - 3);
        }

        throw new \InvalidArgumentException('Unrecognized unix timestamp format');
    }

    /**
     * Schedule the event to run hourly.
     * @return CronJobInterface
     */
    public function hourly()
    {
        return $this->setCronTimeExpression('0 * * * *');
    }

    /**
     * Schedule the event to run daily.
     * @return CronJobInterface
     */
    public function daily()
    {
        return $this->setCronTimeExpression('0 0 * * *');
    }

    /**
     * Schedule the command at a given time.
     *
     * @param  string $time
     *
     * @return CronJobInterface
     */
    public function at($time)
    {
        return $this->dailyAt($time);
    }

    /**
     * Schedule the event to run daily at a given time (10:00, 19:30, etc).
     *
     * @param  string $time
     *
     * @return CronJobInterface
     */
    public function dailyAt($time)
    {
        $segments = explode(':', $time);

        return $this->spliceIntoPosition(2, (int)$segments[0])
                    ->spliceIntoPosition(1, count($segments) == 2 ? (int)$segments[1] : '0');
    }

    /**
     * Splice the given value into the given position of the expression.
     *
     * @param  int    $position
     * @param  string $value
     *
     * @return CronJobInterface
     */
    protected function spliceIntoPosition($position, $value)
    {
        $segments = explode(' ', $this->cronTimeExpression);

        $segments[$position - 1] = $value;

        return $this->setCronTimeExpression(implode(' ', $segments));
    }

    /**
     * Schedule the event to run twice daily.
     *
     * @param  int $first
     * @param  int $second
     *
     * @return CronJobInterface
     */
    public function twiceDaily($first = 1, $second = 13)
    {
        $hours = $first . ',' . $second;

        return $this->spliceIntoPosition(1, 0)
                    ->spliceIntoPosition(2, $hours);
    }

    /**
     * Schedule the event to run only on weekdays.
     * @return CronJobInterface
     */
    public function weekdays()
    {
        return $this->spliceIntoPosition(5, '1-5');
    }

    /**
     * Schedule the event to run only on Mondays.
     * @return CronJobInterface
     */
    public function mondays()
    {
        return $this->days(1);
    }

    /**
     * Set the days of the week the command should run on.
     *
     * @param  array|mixed $days
     *
     * @return CronJobInterface
     */
    public function days($days)
    {
        $days = is_array($days) ? $days : func_get_args();

        return $this->spliceIntoPosition(5, implode(',', $days));
    }

    /**
     * Schedule the event to run only on Tuesdays.
     * @return CronJobInterface
     */
    public function tuesdays()
    {
        return $this->days(2);
    }

    /**
     * Schedule the event to run only on Wednesdays.
     * @return CronJobInterface
     */
    public function wednesdays()
    {
        return $this->days(3);
    }

    /**
     * Schedule the event to run only on Thursdays.
     * @return CronJobInterface
     */
    public function thursdays()
    {
        return $this->days(4);
    }

    /**
     * Schedule the event to run only on Fridays.
     * @return CronJobInterface
     */
    public function fridays()
    {
        return $this->days(5);
    }

    /**
     * Schedule the event to run only on Saturdays.
     * @return CronJobInterface
     */
    public function saturdays()
    {
        return $this->days(6);
    }

    /**
     * Schedule the event to run only on Sundays.
     * @return CronJobInterface
     */
    public function sundays()
    {
        return $this->days(0);
    }

    /**
     * Schedule the event to run weekly.
     * @return CronJobInterface
     */
    public function weekly()
    {
        return $this->setCronTimeExpression('0 0 * * 0');
    }

    /**
     * Schedule the event to run weekly on a given day and time.
     *
     * @param  int    $day
     * @param  string $time
     *
     * @return CronJobInterface
     */
    public function weeklyOn($day, $time = '0:0')
    {
        $this->dailyAt($time);

        return $this->spliceIntoPosition(5, $day);
    }

    /**
     * Schedule the event to run monthly.
     * @return CronJobInterface
     */
    public function monthly()
    {
        return $this->setCronTimeExpression('0 0 1 * *');
    }

    /**
     * Schedule the event to run monthly on a given day and time.
     *
     * @param int    $day
     * @param string $time
     *
     * @return CronJobInterface
     */
    public function monthlyOn($day = 1, $time = '0:0')
    {
        $this->dailyAt($time);

        return $this->spliceIntoPosition(3, $day);
    }

    /**
     * Schedule the event to run quarterly.
     * @return CronJobInterface
     */
    public function quarterly()
    {
        return $this->setCronTimeExpression('0 0 1 */3');
    }

    /**
     * Schedule the event to run yearly.
     * @return CronJobInterface
     */
    public function yearly()
    {
        return $this->setCronTimeExpression('0 0 1 1 *');
    }

    /**
     * Schedule the event to run every minute.
     * @return CronJobInterface
     */
    public function everyMinute()
    {
        return $this->setCronTimeExpression('* * * * *');
    }

    /**
     * Schedule the event to run every five minutes.
     * @return CronJobInterface
     */
    public function everyFiveMinutes()
    {
        return $this->setCronTimeExpression('*/5 * * * *');
    }

    /**
     * Schedule the event to run every ten minutes.
     * @return CronJobInterface
     */
    public function everyTenMinutes()
    {
        return $this->setCronTimeExpression('*/10 * * * *');
    }

    /**
     * Schedule the event to run every thirty minutes.
     * @return CronJobInterface
     */
    public function everyThirtyMinutes()
    {
        return $this->setCronTimeExpression('0,30 * * * *');
    }
}
