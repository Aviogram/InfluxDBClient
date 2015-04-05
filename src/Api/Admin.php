<?php
namespace Aviogram\InfluxDB\Api;

use Aviogram\Common\Plugin\PluginTrait;
use Aviogram\InfluxDB\AbstractApi;

class Admin extends AbstractApi
{
    use PluginTrait;

    protected $plugins = array(
        'database'  => 'Aviogram\InfluxDB\Api\Admin\Database',
        'user'      => 'Aviogram\InfluxDB\Api\Admin\User',
        'retention' => 'Aviogram\InfluxDB\Api\Admin\Retention',
        'privilege' => 'Aviogram\InfluxDB\Api\Admin\Privilege',
    );

    /**
     * @return Admin\Database
     */
    public function database()
    {
        return $this->getPlugin('database', function($class) {
            return new $class($this->getRequest(), $this->getLogger());
        });
    }

    /**
     * @return Admin\User
     */
    public function user()
    {
        return $this->getPlugin('user', function($class) {
            return new $class($this->getRequest(), $this->getLogger());
        });
    }

    /**
     * @return Admin\Retention
     */
    public function retention()
    {
        return $this->getPlugin('retention', function($class) {
            return new $class($this->getRequest(), $this->getLogger());
        });
    }

    /**
     * @return Admin\Privilege
     */
    public function privilege()
    {
        return $this->getPlugin('privilege', function($class) {
            return new $class($this->getRequest(), $this->getLogger());
        });
    }

    /**
     * Checks if the given plugin implements the correct parent classes/interfaces
     *
     * @param  string $class
     *
     * @return boolean
     */
    protected function isCorrectPlugin($class)
    {
        return is_subclass_of($class, 'Aviogram\InfluxDB\AbstractApi');
    }
}
