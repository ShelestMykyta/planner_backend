<?php

namespace App\Exceptions\Task;

use App\Exceptions\BaseException;

class TaskDeletingException extends BaseException
{
    public function __construct(string $message = 'Failed to delete Task.', int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public static function taskNotExist(): self
    {
        return new self('Task is not exist', 404);
    }
}
