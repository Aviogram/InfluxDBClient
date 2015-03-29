<?php
namespace Aviogram\InfluxDB;

class Client
{
    /**
     * @var ClientOptions
     */
    protected $clientOptions;

    /**
     * @param ClientOptions $clientOptions
     */
    public function __construct(ClientOptions $clientOptions)
    {
        $this->clientOptions = $clientOptions;
    }

    /**
     * @return Api\Database
     */
    public function database()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Api\Database($this->getRequest(), $this->getClientOptions()->getLogger());
        }

        return $instance;
    }

    /**
     * @return Api\User
     */
    public function user()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Api\User($this->getRequest(), $this->getClientOptions()->getLogger());
        }

        return $instance;
    }

    /**
     * @return Api\Retention
     */
    public function retention()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Api\Retention($this->getRequest(), $this->getClientOptions()->getLogger());
        }

        return $instance;
    }

    /**
     * @return Api\Privilege
     */
    public function privilege()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Api\Privilege($this->getRequest(), $this->getClientOptions()->getLogger());
        }

        return $instance;
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
}
