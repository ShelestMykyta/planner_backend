<?php

namespace App\Exceptions\Task;

class TaskWrongEndTimeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Finish time must be after start time');
    }
}
