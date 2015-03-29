<?php
namespace Aviogram\InfluxDB\Entity;

class RetentionPolicy implements \JsonSerializable
{
    /**
     * The name of the policy
     *
     * @var string
     */
    protected $name;

    /**
     * How long the data is valid in seconds
     *
     * @var integer
     */
    protected $duration;

    /**
     * The amount of cluster servers for this policy
     *
     * @var integer
     */
    protected $replication;

    /**
     * If this is the default policy
     *
     * @var boolean
     */
    protected $isDefaultPolicy;

    /**
     * Create a policy object
     *
     * @param string $name
     * @param string $duration
     * @param string $replication
     * @param string $isDefaultPolicy
     */
    public function __construct($name, $duration, $replication, $isDefaultPolicy)
    {
        $this->name            = $name;
        $this->duration        = $duration;
        $this->replication     = $replication;
        $this->isDefaultPolicy = $isDefaultPolicy;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getReplication()
    {
        return $this->replication;
    }

    /**
     * @return boolean
     */
    public function isIsDefaultPolicy()
    {
        return $this->isDefaultPolicy;
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
