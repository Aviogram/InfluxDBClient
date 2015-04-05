<?php
namespace Aviogram\InfluxDB\Collection;

use Aviogram\Common\AbstractCollection;

/**
 * @method \Aviogram\InfluxDB\Entity\Result current()
 * @method \Aviogram\InfluxDB\Entity\Result offsetGet($index)
 */
class Result extends AbstractCollection
{

    /**
     * Determines of the value is a valid collection value
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function isValidValue($value)
    {
        return ($value instanceof \Aviogram\InfluxDB\Entity\Result);
    }
}
