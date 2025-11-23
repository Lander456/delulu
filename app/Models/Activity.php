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
        'status',
        'completed',
        'success'
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
    public function getSuccessfullyCompletedCountAttribute(): int
    {
        return $this->users()->wherePivot('completed', true)->count();
    }
    public function getFailedCompletedCountAttribute(): int
    {
        return $this->users()->wherePivot('completed', false)->count();
    }
    public function getPendingCountAttribute(): int
    {
        return $this->users()->wherePivot('completed', null)->count();
    }
    public function getSuccessRateAttribute(): ?float
    {
        return $this->success;
    }
    public function recalculateSuccessRate(): void
    {
        $successful = $this->users()->wherePivot('completed', true)->count();
        $failed = $this->users()->wherePivot('completed', false)->count();

        $total = $successful + $failed;

        if ($total === 0) {
            $this->update(['success' => 0]);
            return;
        }

        $successRate = round(($successful / $total) * 100, 2);
        $this->update(['success' => $successRate]);
    }
}
