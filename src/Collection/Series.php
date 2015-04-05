<?php
namespace Aviogram\InfluxDB\Collection;

use Aviogram\Common\AbstractCollection;

/**
 * @method \Aviogram\InfluxDB\Entity\Serie current()
 * @method \Aviogram\InfluxDB\Entity\Serie offsetGet($index)
 */
class Series extends AbstractCollection
{

    /**
     * Determines of the value is a valid collection value
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function isValidValue($value)
    {
        return ($value instanceof \Aviogram\InfluxDB\Entity\Serie);
    }
}
