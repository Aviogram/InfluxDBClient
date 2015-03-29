<?php
namespace Aviogram\InfluxDB\Collection;

use ArrayIterator;
use JsonSerializable;

/**
 * @method \Aviogram\InfluxDB\Entity\Database current()
 * @method \Aviogram\InfluxDB\Entity\Database offsetGet($index)
 */
class Database extends ArrayIterator implements JsonSerializable
{
    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}
