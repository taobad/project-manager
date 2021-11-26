<?php

declare(strict_types=1);

namespace Square\Http;

/**
 * HTTP response received
 */
class HttpResponse
{
    /**
     * Status code of response
     *
     * @var int
     */
    private $statusCode = null;

    /**
     * Headers received
     *
     * @var array
     */
    private $headers = null;

    /**
     * Raw body of the response
     *
     * @var string
     */
    private $rawBody = null;

    /**
     * Create a new instance of a HttpResponse
     *
     * @param int    $statusCode Response code
     * @param array  $headers    Map of headers
     * @param string $rawBody    Raw response body
     */
    public function __construct(int $statusCode, array $headers, string $rawBody)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->rawBody = $rawBody;
    }

    /**
     * Get status code
     *
     * @return int Status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get headers
     *
     * @return array Map of headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get raw response body
     *
     * @return string Raw body
     */
    public function getRawBody(): string
    {
        return $this->rawBody;
    }
}
