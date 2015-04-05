<?php
namespace Aviogram\InfluxDB\Collection\Admin;

use Aviogram\Common\AbstractCollection;

/**
 * @method \Aviogram\InfluxDB\Entity\Admin\Database current()
 * @method \Aviogram\InfluxDB\Entity\Admin\Database offsetGet($index)
 */
class Database extends AbstractCollection
{
    /**
     * Determines of the value is a valid collection value
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function isValidValue($value)
    {
        return ($value instanceof \Aviogram\InfluxDB\Entity\Admin\Database);
    }
}
