<?php

namespace App\Models;

use App\Exceptions\Task\TaskTimeException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function desks(): BelongsToMany
    {
        return $this->belongsToMany(Desk::class, 'tasks_desks');
    }

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

    /**
     * @throws TaskTimeException
     */
    public function setEndTime(Carbon $date): void
    {
        if (!isset($this->start_time)) {
            throw TaskTimeException::wrongStartTime();
        }

        if ($date->lt($this->start_time)) {
            throw TaskTimeException::wrongEndTime();
        }
        $this->end_time = $date;
    }

}
