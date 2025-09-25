<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function themeAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
