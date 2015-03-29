<?php
namespace Aviogram\InfluxDB\Api;

use Aviogram\InfluxDB\Entity;
use Aviogram\InfluxDB\ClientRequest;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractApi
{
    /**
     * @var ClientRequest
     */
    private $request;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ClientRequest   $request
     * @param LoggerInterface $logger
     */
    public function __construct(ClientRequest $request, LoggerInterface $logger = null)
    {
        $this->request = $request;
        $this->logger  = $logger ?: new NullLogger();
    }

    /**
     * @return ClientRequest
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Abstract method for querying InfluxDB
     *
     * @param string $query
     *
     * @return Entity\QueryResult
     */
    protected function query($query)
    {
        $result = $this->getRequest()
            ->request('/query', $this->getRequest()->query()->addQueryPart('q', $query))
            ->current();

        // Log the error
        if ($result->hasError() === true) {
            $this->getLogger()->error($result->getError());
        }

        return $result;
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }
}
