<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends Model
{

    /** @use HasFactory<\Database\Factories\CampaignFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'theme_id',
        'user_id',
        'current_step_id',
        'success'
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('order');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
    public function currentStep(): BelongsTo
    {
        return $this->belongsTo(Step::class, 'current_step_id');
    }
    public function getSuccessRateAttribute(): float
    {
        return $this->success;
    }

    public function recalculateSuccessRate()
    {
        $successValues = $this->steps
        ->pluck('success')
        ->filter(fn($v) => !is_null($v)); // ignorovat jen null

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
