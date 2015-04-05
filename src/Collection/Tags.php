<?php
namespace Aviogram\InfluxDB\Collection;

use Aviogram\Common\AbstractCollection;

class Tags extends AbstractCollection
{

    /**
     * Determines of the value is a valid collection value
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function isValidValue($value)
    {
        return $value === null || is_scalar($value);
    }
}
