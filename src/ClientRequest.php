<?php
namespace Aviogram\InfluxDB;

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
     * @return Collection\QueryResult
     */
    public function request($uri, Query $query, JsonSerializable $postData = null)
    {
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
                CURLOPT_HEADER     => array('Content-Type: application/json')
            ));
        }

        $response = curl_exec($ch);
        $info     = curl_getinfo($ch);


        if ($info['http_code'] !== 200) {
            if ($response === false) {
                throw new Exception\InvalidApiResponse('Invalid Response Body', $info['status_code']);
            }

            $result = json_decode($response, true);

            if (is_array($result) === false) {
                throw new Exception\InvalidApiResponse('Invalid Response Body', $info['status_code']);
            }

            if (array_key_exists('error', $result) === true) {
                throw new Exception\ApiError($result['error']);
            }
        }

        $result      = json_decode($response, true);
        $queryResults = new Collection\QueryResult();

        foreach ($result['results'] as $row) {
            // Create result row
            $queryResult = new Entity\QueryResult();
            $queryResults->append($queryResult);

            // Set error when there was an query error
            if (array_key_exists('error', $row) === true) {
                $queryResult->setError($row['error']);
                continue;
            }

            // Only parse series keyword
            if (array_key_exists('series', $row) === false) {
                continue;
            }

            foreach ($row['series'] as $serieRow) {
                $name  = array_key_exists('name', $serieRow) ? $serieRow['name'] : null;
                $serie = new Entity\Serie($name);
                $queryResult->addSerie($serie);

                if (array_key_exists('columns', $serieRow) === true) {
                    foreach ($serieRow['columns'] as $column) {
                        $serie->addColumn($column);
                    }
                }

                if (array_key_exists('tags', $serieRow) === true) {
                    foreach ($serieRow['tags'] as $tag) {
                        $serie->addTag($tag);
                    }
                }

                if (array_key_exists('values', $serieRow) === true) {
                    foreach ($serieRow['values'] as $value) {
                        $serie->addValue(new Collection\ArrayIterator($value));
                    }
                }
            }
        }

        return $queryResults;
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
