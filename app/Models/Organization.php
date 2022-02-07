<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'address', 'brief_info', 'super_admin_id'];

    /**
     * Get the superAdmin associated with the Organization
     *
     * @return HasOne
     */
    public function superAdmin(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The users that belong to the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organizations_users');
    }

    public function ownedTasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }
}
