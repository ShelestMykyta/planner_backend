<?php

namespace App\Exceptions\Task;

use App\Exceptions\BaseException;
use App\Exceptions\Render;

class TaskCreatingException extends BaseException
{
    use Render;

    public function __construct()
    {
        parent::__construct('Failed to create Task', 422);
    }
}
