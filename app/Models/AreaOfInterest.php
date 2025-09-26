<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaOfInterest extends Model
{

    /** @use HasFactory<\Database\Factories\AreaOfInterestFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'relevance',
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'area_of_interest_user');
    }
    public function targetDemographics(): BelongsToMany
    {
        return $this->belongsToMany(TargetDemographic::class, 'AOI_target_demographic');
    }
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'area_of_interest_theme');
    }
}
