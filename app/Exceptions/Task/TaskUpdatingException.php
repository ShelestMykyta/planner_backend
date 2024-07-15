<?php

namespace App\Exceptions\Task;

class TaskUpdatingException extends \Exception
{
    public function __construct(string $message = 'Failed to update Task.', int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public static function taskNotExist(): self
    {
        return new self('Task is not exist', 404);
    }
}
