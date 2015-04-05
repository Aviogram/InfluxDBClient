<?php
namespace Aviogram\InfluxDB\Api\Admin;

use Aviogram\InfluxDB\AbstractApi;
use Aviogram\InfluxDB\Collection;

class Retention extends AbstractApi
{
    const DURATION_INFINITE = 'INF';

    /**
     * Create a new retention policy for the given database
     *
     * @param  string  $name
     * @param  string  $database
     * @param  string  $duration     Syntax: (90m, 1h, 1d, 1w) means (90 minutes, 1 hour, 1 day, 1 week)
     * @param  bool    $useAsDefault
     * @param  integer $replicationNumber
     *
     * @return bool
     */
    public function createPolicy(
        $name,
        $database,
        $duration          = self::DURATION_INFINITE,
        $useAsDefault      = false,
        $replicationNumber = 1
    ) {
        if ($this->validateDuration($duration) === false) {
            return false;
        }

        $query = "CREATE RETENTION POLICY {$name} ON {$database} DURATION {$duration} REPLICATION {$replicationNumber}";
        if ($useAsDefault === true) {
            $query .= ' DEFAULT';
        }

        return ($this->query($query)->hasError() === false);
    }

    /**
     * Update a policy
     *
     * @param string            $name
     * @param string            $database
     * @param null | string     $duration
     * @param null | boolean    $useAsDefault
     * @param null | integer    $replicationNumber
     *
     * @return boolean
     */
    public function changePolicy($name, $database, $duration = null, $useAsDefault = null, $replicationNumber = null)
    {
        if ($duration === null && $useAsDefault === null && $replicationNumber === null) {
            $this->getLogger()->error('For updating the retention policy duration or useAsDefault should be set');
            return false;
        }

        $query = "ALTER RETENTION POLICY {$name} ON {$database}";
        if ($duration !== null) {
            if ($this->validateDuration($duration) === false) {
                return false;
            }

            $query .= " DURATION {$duration}";
        }

        if ($replicationNumber !== null) {
            $query .= " REPLICATION {$replicationNumber}";
        }

        if ($useAsDefault === true) {
            $query .= " DEFAULT";
        }

        return ($this->query($query)->hasError() === false);
    }

    public function getPolicies($database)
    {
        $formatter = function($value) {
            if (preg_match('/^([0-9]+)h([0-9]+)m([0-9]+)s$/', $value, $matches) === 0) {
                return $value;
            }

            // Convert syntax to integer
            $seconds  = $matches[3];
            $seconds += $matches[2] * 60;
            $seconds += $matches[1] * 3600;

            return $seconds;
        };

        $query  = "SHOW RETENTION POLICIES {$database}";
        $result = $this->query(
            $query,
            $this->getValueBuilder('Aviogram\InfluxDB\Entity\Admin\RetentionPolicy')
                ->addField('name', 'getName', 'setName')
                ->addField('duration', 'getDuration', 'setDuration', null, $formatter)
                ->addField('replicaN', 'getReplicationNumber', 'setReplicationNumber')
                ->addField('default', 'isDefault', 'setDefault')
        );

        $return = new Collection\Admin\RetentionPolicy();

        foreach ($result->getSeries() as $serie) {
            foreach ($serie->getValues() as $value) {
                $return->append($value);
            }
        }

        return $return;
    }

    /**
     * Validate the duration string
     *
     * @param  string $duration
     *
     * @return bool
     */
    protected function validateDuration($duration)
    {
        if (preg_match('/^([0-9]+(m|h|d|w)|INF)$/', $duration) === 0) {
            $this->getLogger()->error("Duration syntax is invalid. Given {$duration}, should be [0-9]+(m|h|d|w) or INF.");

            return false;
        }

        return true;
    }
}
