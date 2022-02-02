<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
