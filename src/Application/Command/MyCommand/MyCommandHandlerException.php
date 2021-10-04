<?php

namespace App\Application\Command\MyCommand;

use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

/**
 * Class MyCommandHandlerException
 */
class MyCommandHandlerException extends UnrecoverableMessageHandlingException
{
}
