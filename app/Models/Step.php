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
    ];
    public function steps(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, 'campaign_step');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
