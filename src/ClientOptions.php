<?php
namespace Aviogram\InfluxDB;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ClientOptions
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param string $username
     * @param string $password
     * @param string $host
     * @param int $port
     * @param LoggerInterface $logger
     */
    public function __construct(
                       $username = 'root',
                       $password = 'root',
                       $host     = '127.0.0.1',
                       $port     = 8086,
        LoggerInterface $logger  = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->host     = $host;
        $this->port     = $port;
        $this->logger   = $logger ?: new NullLogger();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
