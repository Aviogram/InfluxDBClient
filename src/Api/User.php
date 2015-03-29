<?php
namespace Aviogram\InfluxDB\Api;

use Aviogram\InfluxDB\Collection;
use Aviogram\InfluxDB\Entity;

class User extends AbstractApi
{
    /**
     * Create a new user on the InfluxDB server
     *
     * @param  string $username
     * @param  string $password
     * @return bool
     */
    public function create($username, $password)
    {
        $result = $this->query("CREATE USER {$username} WITH PASSWORD '{$password}'");

        return ($result->hasError() === false);
    }

    /**
     * Delete an user from the InfluxDB server
     *
     * @param  string $username
     * @return bool
     */
    public function delete($username)
    {
        $result = $this->query("DROP USER {$username}");

        return ($result->hasError() === false);
    }

    /**
     * Get a list of users in the InfluxDB Server
     *
     * @return Collection\User
     */
    public function getList()
    {
        $result = $this->query("SHOW USERS");
        $return = new Collection\User();

        foreach ($result->getSeries() as $serie) {
            foreach ($serie->getValues() as $value) {
                $username =           $value->offsetGet(0);
                $isAdmin  = (boolean) $value->offsetGet(1);

                $user = new Entity\User($username, $isAdmin);

                $return->append($user);
            }
        }

        return $return;
    }
}
