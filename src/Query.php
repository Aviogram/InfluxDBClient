<?php
namespace Aviogram\InfluxDB;

class Query
{
    /**
     * @var array
     */
    protected $params = array();

    /**
     * @param  string $field
     * @param  string $value
     *
     * @return $this
     */
    public function addQueryPart($field, $value)
    {
        $this->params[$field] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->params;
    }
}
