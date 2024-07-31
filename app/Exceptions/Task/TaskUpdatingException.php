<?php

namespace App\Exceptions\Task;

class TaskUpdatingException extends TaskException
{
    public function __construct(string $message = 'Failed to update Task.', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
