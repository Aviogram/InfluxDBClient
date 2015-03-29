<?php
namespace Aviogram\InfluxDB\Api;

class Retention extends AbstractApi
{
    const DURATION_INFINITE = 'INF';

    /**
     * Create a new retention policy for the given database
     *
     * @param  string $name
     * @param  string $database
     * @param  string $duration     Syntax: (90m, 1h, 1d, 1w) means (90 minutes, 1 hour, 1 day, 1 week)
     * @param  bool   $useAsDefault
     *
     * @return bool
     */
    public function createPolicy(
        $name,
        $database,
        $duration     = self::DURATION_INFINITE,
        $useAsDefault = false
    ) {
        if (preg_match('/^([0-9]+(m|h|d|w)|INF)$/', $duration) === 0) {
            $this->getLogger()->error("Duration syntax is invalid. Given {$duration}, should be [0-9]+(m|h|d|w) or INF.");

            return false;
        }

        $query = "CREATE RETENTION POLICY {$name} ON {$database} DURATION {$duration} REPLICATION 1";
        if ($useAsDefault === true) {
            $query .= ' DEFAULT';
        }

        return ($this->query($query)->hasError() === false);
    }

    public function changePolicy()
    {

    }

    public function getPolicies($database)
    {
        $query = "SHOW RETENTION POLICIES {$database}";

        var_dump($this->query($query));
    }
}
