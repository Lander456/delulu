<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => ['datetime'],
            'password' => ['hashed'],
        ];
    }

    public function areasOfInterest(): BelongsToMany
    {
        return $this->belongsToMany(AreaOfInterest::class, 'area_of_interest_user');
    }

    public function targetDemographics(): BelongsToMany
    {
        return $this->belongsToMany(TargetDemographic::class, 'target_demographic_user');
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function assignedCampaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }
    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class);
    }

    public function activityRequests(): HasMany
    {
        return $this->hasMany(ActivityRequest::class);
    }

    public function getSteps()
    {
        return Step::where('user_id', '=', $this->id)
            ->orWhereHas('campaign', function ($query) {
                $query->where('user_id', '=', $this->id)
                    ->orWhereHas('theme', function ($query) {
                        $query->where('user_id', '=', $this->id);
                    });
            })->get();
    }

    public function getCampaigns()
    {
        return Campaign::where('user_id', '=', $this->id)
            ->orWhereHas('theme', function ($query) {
                $query->where('user_id', '=', $this->id);
            })->get();
    }

    public function getRoleAttribute()
    {
        return $this->getRoleNames()->first();
    }
}
