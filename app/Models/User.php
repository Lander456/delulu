<?php

namespace App\Models;

use App\Enums\RolesEnum;
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
        return $this->belongsToMany(Activity::class)
            ->withPivot('completed')
            ->withTimestamps();
    }

    /**
     * Coordinators steps.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    /**
     * Campain leaders campaigns.
     */
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function assignedCampaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class)
            ->withTimestamps();
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
        if( $this->hasRole(RolesEnum::SYSADMIN->value)){
            return Step::all();
        }


        $userId = $this->id;
        return Step::where('user_id', '=', $userId)
            ->orWhereHas('campaign', function ($query)use($userId) : void {
                $query->where('user_id', '=', $userId)
                    ->orWhereHas('users', function ($query) use ($userId) {
                        $query->where('users.id', $userId);
                    })
                    ->orWhereHas('theme', function ($query)use($userId) {
                        $query->where('user_id', '=', $userId);
                    });
            })
            ->orWhereHas('activities.users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->distinct()
            ->get();
    }

    public function getCampaigns()
    {
         if( $this->hasRole(RolesEnum::SYSADMIN->value)){
            return Campaign::all();
        }

        $userId = $this->id;
        return Campaign::where('user_id', '=', $userId)
            ->orWhereHas('theme', function ($query)use($userId) {
                $query->where('user_id', '=', $userId);
            })
            ->orWhereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->distinct()
            ->get();
    }

    public function getRoleAttribute()
    {
        return $this->getRoleNames()->first();
    }
}
