<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ["details", "task_category_id"];

    // Relationship
    /**
     * Get the category that owns the Task
     *
     * @return BelongsTo
     */
    public function taskCategory(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class);
    }
}
