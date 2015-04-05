<?php
namespace Aviogram\InfluxDB\Api\Admin;

use Aviogram\InfluxDB\AbstractApi;
use Aviogram\InfluxDB\Collection;
use Aviogram\InfluxDB\Entity;

class Database extends AbstractApi
{
    /**
     * Creates a database by InfluxDB
     *
     * @param $database
     *
     * @return boolean
     */
    public function create($database)
    {
        $result = $this->query('CREATE DATABASE ' . $database);

        return ($result->hasError() !== false);
    }

    /**
     * Delete a database from the InfluxDB
     *
     * @param  $database
     *
     * @return bool
     */
    public function delete($database)
    {
        $result = $this->query('DROP DATABASE ' . $database);

        return ($result->hasError() !== false);
    }

    /**
     * Checks if an database exists
     *
     * @param  string $database
     * @return bool
     */
    public function hasDatabase($database)
    {
        $list = $this->getList();

        foreach ($list as $item) {
            if ($item->getName() === $database) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return list of databases
     *
     * @return Collection\Admin\Database
     */
    public function getList()
    {
        $result = $this->query(
            'SHOW DATABASES',
            $this->getValueBuilder('Aviogram\InfluxDB\Entity\Admin\Database')
                ->addField('name', 'getName', 'setName')
        );

        $return = new Collection\Admin\Database();

        foreach ($result->getSeries() as $row) {
            foreach ($row->getValues() as $value) {
                $return->append($value);
            }
        }

        return $return;
    }
}
