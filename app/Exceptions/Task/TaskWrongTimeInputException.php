<?php

namespace App\Exceptions\Task;

class TaskWrongTimeInputException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Wrong time input');
    }
}
