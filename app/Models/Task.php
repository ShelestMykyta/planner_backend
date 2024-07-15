<?php

namespace App\Models;

use App\Exceptions\Task\TaskTimeException;
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
                throw TaskTimeException::wrongTimeNoEndTime();
            }
            if ($model->start_time && $model->end_time) {
                if ($model->end_time->lt($model->start_time)) {
                    throw TaskTimeException::wrongEndTime();
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
            throw TaskTimeException::wrongEndTime();
        }
        $this->end_time = $date;
    }

}
