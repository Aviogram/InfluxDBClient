<?php
namespace Aviogram\InfluxDB\Entity;

use JsonSerializable;

class User implements JsonSerializable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $isAdmin;

    /**
     * @param string  $name
     * @param boolean $isAdmin
     */
    public function __construct($name, $isAdmin)
    {
        $this->name    = $name;
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isIsAdmin()
    {
        return $this->isAdmin;
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
        return get_object_vars($this);
    }
}
