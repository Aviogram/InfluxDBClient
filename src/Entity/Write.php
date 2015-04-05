<?php
namespace Aviogram\InfluxDB\Entity;

use Aviogram\Common\AbstractEntity;
use Aviogram\InfluxDB\Collection;
use DateTime;

class Write extends AbstractEntity
{
    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $retentionPolicy;

    /**
     * @var Collection\Tags
     */
    protected $tags;

//    /**
//     * @var Datetime
//     */
//    protected $timestamp;

    /**
     * @var Collection\Points
     */
    protected $points;

    /**
     * @param string $database
     * @param string $retentionPolicy
     */
    public function __construct($database, $retentionPolicy = 'default')
    {
        $this->database        = $database;
        $this->retentionPolicy = $retentionPolicy;

//        $this->timestamp = new Datetime();
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $database
     *
     * @return Write
     */
    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    /**
     * @return string
     */
    public function getRetentionPolicy()
    {
        return $this->retentionPolicy;
    }

    /**
     * @param string $retentionPolicy
     *
     * @return Write
     */
    public function setRetentionPolicy($retentionPolicy)
    {
        $this->retentionPolicy = $retentionPolicy;

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
     * @param string $name
     * @param string $value
     *
     * @return Write
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
     * @return DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param DateTime $timestamp
     *
     * @return Write
     */
    public function setTimestamp(DateTime $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return Collection\Points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Create a new point entity
     *
     * @param  string $name
     *
     * @return Point
     */
    public function createPoint($name)
    {
        return new Point($name);
    }

    /**
     * @param Point $point
     *
     * @return Write
     */
    public function addPoint(Point $point)
    {
        if ($this->points === null) {
            $this->points = new Collection\Points();
        }

        $this->points->append($point);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        foreach ($data as $index => $row) {
            if ($row === null) {
                unset($data[$index]);
            }
        }

        return $data;
    }
}
