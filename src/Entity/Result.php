<?php
namespace Aviogram\InfluxDB\Entity;

use Aviogram\Common\AbstractEntity;
use Aviogram\InfluxDB\Collection;

class Result extends AbstractEntity
{
    /**
     * @var Collection\Series
     */
    protected $series;

    /**
     * @var string | NULL
     */
    protected $error;

    /**
     * Construct this entity
     */
    public function __construct()
    {
        $this->series = new Collection\Series();
    }

    /**
     * @return Collection\Series
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param Collection\Series $series
     *
     * @return Result
     */
    public function setSeries(Collection\Series $series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * @return NULL|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->error !== null;
    }

    /**
     * @param NULL|string $error
     *
     * @return Result
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }
}
