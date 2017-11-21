<?php

namespace Framework\Terminal\Commands;

use Framework\Base\Application\ApplicationAwareTrait;

/**
 * Class DatabaseSeedersHandler
 * @package Framework\Terminal\Commands
 */
class DatabaseSeedersHandler implements CommandHandlerInterface
{
    use ApplicationAwareTrait;

    /**
     * @param array $paramValues
     *
     * @return string|null
     */
    public function run(array $paramValues = [])
    {
        $seeders = $this->getSeeders();
        $seederName = $paramValues['seederName'];

        if  (class_exists($seeders[$seederName]) === true) {
            /** @var \Framework\Terminal\Seeder\SeederInterface $seeder */
            $seeder = new $seeders[$seederName];
            return $seeder->setApplication($this->getApplication())
                          ->seed();
        }
        return null;
    }

    /**
     * @return array
     */
    public function getSeeders(): array
    {
        return $this->getApplication()->getRegisteredSeeders();
    }
}
