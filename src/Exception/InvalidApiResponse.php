<?php
namespace Aviogram\InfluxDB\Exception;

use Exception;
use RuntimeException;

class InvalidApiResponse extends RuntimeException
{
    /**
     * @var string | NULL
     */
    protected $responseBody = null;

    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     * @param string    $responseBody
     */
    public function __construct($message = "", $code = 0, Exception $previous = null, $responseBody = null)
    {
        parent::__construct($message, $code, $previous);

        $this->responseBody = $responseBody;
    }

    /**
     * @return NULL|string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }
}
