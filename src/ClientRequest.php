<?php
namespace Aviogram\InfluxDB;

use Aviogram\Common\Hydrator\ByConfig;
use Aviogram\Common\Hydrator\ByConfigBuilder;
use JsonSerializable;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ClientRequest
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
    private $logger;

    /**
     * @param string $username
     * @param string $password
     * @param string $host
     * @param int $port
     * @param LoggerInterface $logger
     */
    public function __construct(
        $username,
        $password,
        $host                   = '127.0.0.1',
        $port                   = 8086,
        LoggerInterface $logger = null
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->host     = $host;
        $this->port     = $port;
        $this->logger   = $logger ?: new NullLogger();
    }

    /**
     * Perform InfluxDB request
     *
     * @param string           $uri
     * @param Query            $query
     * @param JsonSerializable $postData
     *
     * @return mixed
     */
    public function request($uri, Query $query, JsonSerializable $postData = null) {
        $params = clone $query;
        $params->addQueryPart('u', $this->username);
        $params->addQueryPart('p', $this->password);

        $url = "http://{$this->host}:{$this->port}{$uri}?" . http_build_query($params->getArrayCopy());

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ));

        if ($postData !== null) {
            curl_setopt_array($ch, array(
                CURLOPT_POST       => true,
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            ));
        }

        $response = curl_exec($ch);
        $info     = curl_getinfo($ch);

        if ($info['http_code'] !== 200) {
            if ($response === false) {
                throw new Exception\InvalidApiResponse('Empty Response Body', $info['http_code']);
            }

            $result = json_decode($response, true);

            if (is_array($result) === false) {
                throw new Exception\InvalidApiResponse('Invalid Response Body', $info['http_code'], null, $response);
            }

            if (array_key_exists('error', $result) === true) {
                throw new Exception\ApiError($result['error']);
            }
        }

        // Decode result
        $result = json_decode($response, true);

        // Return results
        return $result['results'];
    }

    /**
     * Get an query object
     *
     * @return Query
     */
    public function query()
    {
        return new Query();
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }
}
