<?php

namespace App\DTO;

readonly class TaskDTO extends AbstractDTO
{
    public function __construct(
        public string  $title,
        public string  $description,
        public string  $date,
        public string  $start_time,
        public ?string  $end_time,
        public ?string $id = null
    ) {}
}
