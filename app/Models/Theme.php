<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function target_demographics(): BelongsToMany
    {
        return $this->belongsToMany(TargetDemographic::class, 'target_demographic_theme');
    }

    public function infoSources(): BelongsToMany
    {
        return $this->belongsToMany(InformationSource::class, 'information_source_theme');
    }
}
