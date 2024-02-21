<?php

namespace App\Exceptions\Task;

class ErrorTaskCreatingException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Failed to create Task');
    }
}
