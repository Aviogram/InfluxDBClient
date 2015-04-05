<?php
namespace Aviogram\InfluxDB\Entity\Admin;

use Aviogram\Common\AbstractEntity;

class User extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $admin;

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
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param boolean $admin
     *
     * @return User
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }
}
