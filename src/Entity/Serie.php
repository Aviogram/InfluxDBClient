<?php
namespace Aviogram\InfluxDB\Entity;

use Aviogram\InfluxDB\Collection;

class Serie implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection\ArrayIterator
     */
    protected $tags;

    /**
     * @var Collection\ArrayIterator
     */
    protected $columns;

    /**
     * @var Collection\ArrayIterator
     */
    protected $values;

    /**
     * Construct internal objects
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name    = $name;
        $this->tags    = new Collection\ArrayIterator();
        $this->columns = new Collection\ArrayIterator();
        $this->values  = new Collection\ArrayIterator();
    }

    /**
     * @param  string $tag
     *
     * @return $this
     */
    public function addTag($tag)
    {
        $this->tags->append($tag);

        return $this;
    }

    /**
     * @param  string $column
     *
     * @return $this
     */
    public function addColumn($column)
    {
        $this->columns->append($column);

        return $this;
    }

    /**
     * @param Collection\ArrayIterator $values
     *
     * @return $this
     */
    public function addValue(Collection\ArrayIterator $values)
    {
        $this->values->append($values);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection\ArrayIterator
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return Collection\ArrayIterator
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return Collection\ArrayIterator
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
