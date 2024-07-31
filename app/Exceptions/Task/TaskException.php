<?php

namespace App\Exceptions\Task;

use App\Exceptions\BaseException;

class TaskException extends BaseException
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }

    public static function taskNotExist(): static
    {
        return new static('Task is not exist', 404);
    }
}
