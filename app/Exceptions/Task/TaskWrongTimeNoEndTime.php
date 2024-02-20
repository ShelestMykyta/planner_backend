<?php

namespace App\Exceptions\Task;

class TaskWrongTimeNoEndTime extends \Exception
{
    public function __construct()
    {
        parent::__construct('Wrong time input. No end time.');
    }
}
