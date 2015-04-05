<?php
namespace Aviogram\InfluxDB\Entity\Admin;

use Aviogram\Common\AbstractEntity;

class Database extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

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
     * @return Database
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
