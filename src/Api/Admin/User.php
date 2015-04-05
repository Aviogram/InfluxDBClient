<?php
namespace Aviogram\InfluxDB\Api\Admin;

use Aviogram\InfluxDB\AbstractApi;
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
        $result = $this->query(
            "SHOW USERS",
            $this->getValueBuilder('Aviogram\InfluxDB\Entity\Admin\User')
                ->addField('user', 'getName', 'setName')
                ->addField('admin', 'isAdmin', 'setAdmin')
        );

        $return = new Collection\Admin\User();

        foreach ($result->getSeries() as $serie) {
            foreach($serie->getValues() as $value) {
                $return->append($value);
            }
        }

        return $return;
    }
}
