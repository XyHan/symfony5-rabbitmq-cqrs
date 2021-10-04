<?php

namespace App\Application\Command\MyCommand;

use App\Domain\Command\Command;

/**
 * Class MyCommand
 */
final class MyCommand implements Command
{
    /**
     * @var string
     */
    private string $requestId;

    /**
     * @var string
     */
    private string $userUuid;

    /**
     * @var string
     */
    private string $uuid;

    /**
     * @param string $requestId
     * @param string $userUuid
     * @param string $uuid
     */
    public function __construct(
        string $requestId,
        string $userUuid,
        string $uuid
    ) {
        $this->requestId = $requestId;
        $this->userUuid = $userUuid;
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getUserUuid(): string
    {
        return $this->userUuid;
    }
    
    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return get_class($this);
    }
}
