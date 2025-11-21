<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends Model
{

    /** @use HasFactory<\Database\Factories\CampaignFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function currentStep(): BelongsTo
    {
        return $this->belongsTo(Step::class, 'current_step_id');
    }
    public function getSuccessRateAttribute(): float
    {
        $successValues = $this->steps->pluck('success_rate');

        if ($successValues->isEmpty()) {
            return 0;
        }

        return round($successValues->avg(), 2);
    }
}
