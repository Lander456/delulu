<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'success',
        'step_id',
        'user_id',
        'status'
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'activity_user')
            ->withPivot('completed')
            ->withTimestamps();
    }
    public function step(): BelongsTo
    {
        return $this->belongsTo(Step::class);
    }
    public function activityRequests(): HasMany
    {
        return $this->hasMany(ActivityRequest::class);
    }
}
