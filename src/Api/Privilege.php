<?php
namespace Aviogram\InfluxDB\Api;

class Privilege extends AbstractApi
{
    CONST TYPE_GRANT  = 'GRANT',
          TYPE_REVOKE = 'REVOKE';

    CONST PRIVILEGE_ALL   = 'ALL',
          PRIVILEGE_READ  = 'READ',
          PRIVILEGE_WRITE = 'WRITE';

    /**
     * Grant a user read rights on the given database
     *
     * @param  $username
     * @param  $database
     *
     * @return bool
     */
    public function grantReadRight($username, $database)
    {
        return $this->setPrivilege(static::TYPE_GRANT, static::PRIVILEGE_READ, $username, $database);
    }

    /**
     * Revoke a user read rights on the given database
     *
     * @param  $username
     * @param  $database
     *
     * @return bool
     */
    public function revokeReadRight($username, $database)
    {
        return $this->setPrivilege(static::TYPE_REVOKE, static::PRIVILEGE_READ, $username, $database);
    }

    /**
     * Grant a user read write on the given database
     *
     * @param  $username
     * @param  $database
     *
     * @return bool
     */
    public function grantWriteRight($username, $database)
    {
        return $this->setPrivilege(static::TYPE_GRANT, static::PRIVILEGE_WRITE, $username, $database);
    }

    /**
     * Revoke a user write rights on the given database
     *
     * @param  $username
     * @param  $database
     *
     * @return bool
     */
    public function revokeWriteRight($username, $database)
    {
        return $this->setPrivilege(static::TYPE_REVOKE, static::PRIVILEGE_WRITE, $username, $database);
    }

    /**
     * Grant a user all rights on the given database
     *
     * @param  $username
     * @param  $database
     *
     * @return bool
     */
    public function grantAllRights($username, $database)
    {
        return $this->setPrivilege(static::TYPE_GRANT, static::PRIVILEGE_ALL, $username, $database);
    }

    /**
     * Revoke a user all rights on the given database
     *
     * @param  $username
     * @param  $database
     *
     * @return bool
     */
    public function revokeAllRights($username, $database)
    {
        return $this->setPrivilege(static::TYPE_REVOKE, static::PRIVILEGE_ALL, $username, $database);
    }

    /**
     * Grant administrator rights for the given user
     *
     * @param  $username
     *
     * @return bool
     */
    public function grantAdminRights($username)
    {
        return $this->setPrivilege(static::TYPE_GRANT, static::PRIVILEGE_ALL, $username);
    }

    /**
     * Revoke administrator rights for the given user
     *
     * @param  $username
     *
     * @return bool
     */
    public function revokeAdminRights($username)
    {
        return $this->setPrivilege(static::TYPE_REVOKE, static::PRIVILEGE_ALL, $username);
    }

    /**
     * Generic method for the privileges
     *
     * @param string        $type
     * @param string        $privilege
     * @param string        $username
     * @param string | null $database
     *
     * @return boolean
     */
    protected function setPrivilege($type, $privilege, $username, $database = null)
    {
        $parts = array($type, $privilege);

        if ($database !== null) {
            $parts[] = "ON {$database}";
        }

        if ($type === static::TYPE_GRANT) {
            $parts[] = "TO {$username}";
        } else if ($type === static::TYPE_REVOKE) {
            $parts[] = "FROM {$username}";
        }

        $query = implode(' ', $parts);

        echo $query . PHP_EOL;

        return ($this->query($query)->hasError() === false);
    }
}
