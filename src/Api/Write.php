<?php
namespace Aviogram\InfluxDB\Api;

use Aviogram\InfluxDB\AbstractApi;
use Aviogram\InfluxDB\Entity\Write as WriteEntity;

class Write extends AbstractApi
{
    /**
     * @param  WriteEntity $write
     * @return bool
     */
    public function add(WriteEntity $write)
    {
        $this->getRequest()->request(
            '/write',
            $this->getRequest()->query(),
            $write
        );

        return true;
    }

    /**
     * Creates a new write entity which will be used to write new data to the influxDB database
     *
     * @param string $database
     * @param string $retentionPolicy
     *
     * @return WriteEntity
     */
    public function getWriteEntity($database, $retentionPolicy = 'default')
    {
        return new WriteEntity($database, $retentionPolicy);
    }
}
