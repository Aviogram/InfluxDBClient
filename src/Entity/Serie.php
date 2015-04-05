<?php
namespace Aviogram\InfluxDB\Entity;

use Aviogram\Common\AbstractEntity;
use Aviogram\InfluxDB\Collection;

class Serie extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection\Tags
     */
    protected $tags;

    /**
     * @var Collection\Values
     */
    protected $values;

    /**
     * Create inner entities
     */
    public function __construct()
    {
        $this->tags   = new Collection\Tags();
        $this->values = new Collection\Values();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Serie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection\Tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Collection\Tags $tags
     *
     * @return Serie
     */
    public function setTags(Collection\Tags $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Collection\Values
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param Collection\Values $values
     *
     * @return Serie
     */
    public function setValues(Collection\Values $values)
    {
        $this->values = $values;

        return $this;
    }
}
