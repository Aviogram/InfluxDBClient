<?php
namespace Aviogram\InfluxDB\Collection;

use Aviogram\Common\AbstractCollection;

/**
 * @method \Aviogram\InfluxDB\Entity\Point current()
 * @method \Aviogram\InfluxDB\Entity\Point offsetGet($index)
 */
class Points extends AbstractCollection
{

    /**
     * Determines of the value is a valid collection value
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function isValidValue($value)
    {
        return ($value instanceof \Aviogram\InfluxDB\Entity\Point);
    }
}
