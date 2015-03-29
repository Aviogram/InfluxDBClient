<?php
namespace Aviogram\InfluxDB\Entity;

use Aviogram\InfluxDB\Collection;

class QueryResult implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $error;

    /**
     * @var Collection\Serie
     */
    protected $series;

    /**
     * Construct internal objects
     */
    public function __construct()
    {
        $this->series = new Collection\Serie();
    }

    /**
     * @param  string $error
     *
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Returns if any error occurred during executing the query
     *
     * @return bool
     */
    public function hasError()
    {
        return ($this->error !== null);
    }

    /**
     * Return an error message when available
     *
     * @return string | NULL when no error has been given
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get the serie collection
     *
     * @return Collection\Serie
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Add a new serie
     *
     * @param  Serie $serie
     * @return $this
     */
    public function addSerie(Serie $serie)
    {
        $this->getSeries()->append($serie);

        return $this;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array('error' => $this->error, 'series' => $this->getSeries());
    }
}
