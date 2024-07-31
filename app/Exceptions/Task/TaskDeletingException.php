<?php

namespace App\Exceptions\Task;

class TaskDeletingException extends TaskException
{
    public function __construct(string $message = 'Failed to delete Task.', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
