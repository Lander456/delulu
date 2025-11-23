<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Step extends Model
{

    /** @use HasFactory<\Database\Factories\StepFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'campaign_id',
        'user_id',
        'order',
        'success'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getSuccessRateAttribute(): float
    {
        return $this->success;
    }

    public function recalculateSuccessRate() {
        $successValues = $this->activities
        ->pluck('success')
        ->filter(fn($v) => !is_null($v));

        if ($successValues->isEmpty()) {
            $this->update(['success' => 0]);
            return;
        }

        $avg = round($successValues->avg(), 2);

        $this->update([
            'success' => $avg
        ]);
    }
}
