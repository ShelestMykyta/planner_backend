<?php

namespace App\Exceptions\Task;

class ErrorTaskUpdatingException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Failed to update Task.');
    }
}
