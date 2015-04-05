<?php
namespace Aviogram\InfluxDB;

use Aviogram\Common\Plugin\PluginTrait;

class Client
{
    use PluginTrait;

    /**
     * @var ClientOptions
     */
    protected $clientOptions;

    /**
     * @var array
     */
    protected $plugins = array(
        'admin' => 'Aviogram\InfluxDB\Api\Admin',
        'write' => 'Aviogram\InfluxDB\Api\Write',
    );

    /**
     * @param ClientOptions $clientOptions
     */
    public function __construct(ClientOptions $clientOptions)
    {
        $this->clientOptions = $clientOptions;
    }

    /**
     * @return Api\Admin
     */
    public function admin()
    {
        return $this->getPlugin('admin', function($class) {
            return new $class($this->getRequest(), $this->getClientOptions()->getLogger());
        });
    }

    /**
     * @return Api\Write
     */
    public function write()
    {
        return $this->getPlugin('write', function($class) {
            return new $class($this->getRequest(), $this->getClientOptions()->getLogger());
        });
    }

    /**
     * @return ClientRequest
     */
    protected function getRequest()
    {
        static $request = null;

        if ($request === null) {
            $request = new ClientRequest(
                $this->getClientOptions()->getUsername(),
                $this->getClientOptions()->getPassword(),
                $this->getClientOptions()->getHost(),
                $this->getClientOptions()->getPort(),
                $this->getClientOptions()->getLogger()
            );
        }

        return $request;
    }

    /**
     * @return ClientOptions
     */
    protected function getClientOptions()
    {
        return $this->clientOptions;
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
