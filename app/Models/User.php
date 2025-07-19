<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function coverLetter(): HasMany {
        return $this->hasMany(CoverLetter::class);
    }

    public function businessCertificate(): HasMany {
        return $this->hasMany(BusinessCertificate::class);
    }

    public function marriageCertificate(): HasMany {
        return $this->hasMany(MarriageCertificate::class);
    }

    public function domicileCertificate(): HasMany {
        return $this->hasMany(DomicileCertificate::class);
    }

    public function unmarriedCertificate(): HasMany {
        return $this->hasMany(UnmarriedCertificate::class);
    }

}
