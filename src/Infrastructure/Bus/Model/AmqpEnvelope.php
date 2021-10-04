<?php

namespace App\Infrastructure\Bus\Model;

/**
 * Class AmqpEnvelope
 */
class AmqpEnvelope
{
    /**
     * @var string
     */
    private string $body;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return AmqpEnvelope
     */
    public function setBody(string $body): AmqpEnvelope
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return AmqpEnvelope
     */
    public function setHeaders(array $headers): AmqpEnvelope
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return get_class($this);
    }
}
