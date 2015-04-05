<?php
namespace Aviogram\InfluxDB\Entity\Admin;

use Aviogram\Common\AbstractEntity;

class RetentionPolicy extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var integer
     */
    protected $replicationNumber;

    /**
     * @var boolean
     */
    protected $default;

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
     * @return RetentionPolicy
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return RetentionPolicy
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int
     */
    public function getReplicationNumber()
    {
        return $this->replicationNumber;
    }

    /**
     * @param int $replicationNumber
     *
     * @return RetentionPolicy
     */
    public function setReplicationNumber($replicationNumber)
    {
        $this->replicationNumber = $replicationNumber;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param boolean $default
     *
     * @return RetentionPolicy
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }
}
