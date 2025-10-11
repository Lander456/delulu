<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TargetDemographic extends Model
{

    /** @use HasFactory<\Database\Factories\TargetDemographicFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'difficulty',
        'ethics',
        'relevance',
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'target_demographic_user');
    }
    public function areasOfInterest(): BelongsToMany
    {
        return $this->belongsToMany(AreaOfInterest::class, 'AOI_target_demographic');
    }
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'target_demographic_theme');
    }
    public function informationSources(): BelongsToMany
    {
        return $this->belongsToMany(InformationSource::class, 'IS_target_demographic');
    }

}
