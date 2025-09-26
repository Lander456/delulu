<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'success'
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'activity_user');
    }
    public function steps(): BelongsToMany
    {
        return $this->belongsToMany(Step::class, 'activity_step');
    }
}
