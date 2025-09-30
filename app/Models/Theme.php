<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theme extends Model
{

    /** @use HasFactory<\Database\Factories\ThemeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function areasOfInterest(): BelongsToMany
    {
        return $this->belongsToMany(AreaOfInterest::class, 'area_of_interest_theme');
    }

    public function targetDemographics(): BelongsToMany
    {
        return $this->belongsToMany(TargetDemographic::class, 'target_demographic_theme');
    }

    public function informationSources(): BelongsToMany
    {
        return $this->belongsToMany(InformationSource::class, 'information_source_theme');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
