<?php

namespace App\Exceptions\Task;

class TaskCreatingException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Failed to create Task');
    }
}
