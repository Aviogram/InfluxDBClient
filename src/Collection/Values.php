<?php
namespace Aviogram\InfluxDB\Collection;

use Aviogram\Common\AbstractCollection;

/**
 * @method \Aviogram\InfluxDB\Entity\Value current()
 * @method \Aviogram\InfluxDB\Entity\Value offsetGet($index)
 */
class Values extends AbstractCollection
{
    /**
     * Determines of the value is a valid collection value
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function isValidValue($value)
    {
        return true;
    }
}
