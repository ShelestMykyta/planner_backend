<?php

namespace App\Models;

use App\Exceptions\Task\TaskWrongEndTimeException;
use App\Exceptions\Task\TaskWrongTimeNoEndTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
    ];

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            if ($model->start_time && !$model->end_time) {
                throw new TaskWrongTimeNoEndTime();
            }
            if ($model->start_time && $model->end_time) {
                if ($model->end_time->lt($model->start_time)) {
                    throw new TaskWrongEndTimeException();
                }
            }
        });
    }

    public function setStartTime(Carbon $date): void
    {
        $this->start_time = $date;
    }

    public function setEndTime(Carbon $date): void
    {
        if ($date->lt($this->start_time)) {
            throw new TaskWrongEndTimeException();
        }
        $this->end_time = $date;
    }

}
