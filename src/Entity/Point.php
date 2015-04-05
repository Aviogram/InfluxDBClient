<?php
namespace Aviogram\InfluxDB\Entity;

use Aviogram\Common\AbstractEntity;
use Aviogram\InfluxDB\Collection;
use DateTime;

class Point extends AbstractEntity
{
    const PRECISION_NANOSECONDS  = 'n',
          PRECISION_MICROSECONDS = 'u',
          PRECISION_MILLISECONDS = 'ms',
          PRECISION_SECONDS      = 's',
          PRECISION_MINUTES      = 'm',
          PRECISION_HOURS        = 'h';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Collection\Fields
     */
    protected $fields;

    /**
     * @var integer | NULL
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $precision;

    /**
     * @var Collection\Tags
     */
    protected $tags;

    /**
     * Construct a new point
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
     * @return Point
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection\Fields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param  string $fieldName
     * @param  string $value
     *
     * @return Point
     */
    public function addField($fieldName, $value)
    {
        if($this->fields === null) {
            $this->fields = new Collection\Fields();
        }

        $this->fields->offsetSet($fieldName, $value);

        return $this;
    }

    /**
     * @return int|NULL
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int|DateTime $timestamp
     * @param string       $precision (static::PRECISION_*, when DateTime has been given this will be overridden)
     *
     * @return Point
     */
    public function setTimestamp($timestamp, $precision = self::PRECISION_SECONDS)
    {
        // When DateTime has been given, convert it to a timestamp
        if (($timestamp instanceof DateTime) === true) {
            $this->timestamp = $timestamp->setTimezone(new \DateTimeZone('UTC'))->getTimestamp();
            $this->precision = static::PRECISION_SECONDS;

            return $this;
        }

        $this->timestamp = $timestamp;
        $this->precision = $precision;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrecision()
    {
        return $this->precision;
    }


    /**
     * @return Collection\Tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param  string $name
     * @param  mixed  $value
     *
     * @return Point
     */
    public function addTag($name, $value)
    {
        if ($this->tags === null) {
            $this->tags = new Collection\Tags();
        }

        $this->tags->offsetSet($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        // Get rid of the empty values
        foreach ($data as $index => $row) {
            if ($row === null) {
                unset($data[$index]);
            }
        }

        return $data;
    }

}
