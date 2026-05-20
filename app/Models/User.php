<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
// use Laravel\Passport\HasApiTokens;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;


class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable ,HasRoles ,InteractsWithMedia , HasTranslations , HasApiTokens;

    protected static function booted()
    {
        static::creating(function ($user) {
            if ($user->is_guest && !$user->guest_token) {
                $user->guest_token = Str::uuid();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_guest',
        'guest_token'
    ];

     /**
     * The attributes to translate.
     *
     * @var list<string>
     */
    public $translatable = ['name', 'description'];

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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function loadProfileData(): self
    {
        return $this->load([

            'credit:id,user_id,balance,used,purchased_total',

            'creditTransactions' => function ($q) {

                $q->select(
                    'id',
                    'user_id',
                    'type',
                    'credits',
                    'balance_after',
                    'description',
                    'created_at'
                )
                ->latest()
                ->limit(5);
            },
            // 'resumes' => function ($q) {

            //     $q->select(
            //         'id',
            //         'user_id',
            //         'type',
            //         'credits',
            //         'balance_after',
            //         'description',
            //         'created_at'
            //     )
            //     ->latest()
            //     ->limit(5);
            // }
        ])->loadCount('resumes')->loadCount('analyses');

    }

    public function credit()
    {
        return $this->hasOne(Credit::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function analyses()
    {
        return $this->hasMany(Analyse::class);
    }
}
