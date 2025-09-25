<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InformationSource extends Model
{

    /** @use HasFactory<\Database\Factories\InformationSourceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function targetDemographics(): BelongsToMany
    {
        return $this->belongsToMany(TargetDemographic::class, 'IS_target_demographic');
    }

    public function utilizedBy(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'information_source_theme');
    }
}
