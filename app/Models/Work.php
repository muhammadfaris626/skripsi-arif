<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['work_name'];

    public function resident(): HasMany {
        return $this->hasMany(Resident::class);
    }

    public function marriageCertificate(): HasMany {
        return $this->hasMany(MarriageCertificate::class);
    }

    public function domicileCertificate(): HasMany {
        return $this->hasMany(DomicileCertificate::class);
    }

    public function coverLetter(): HasMany {
        return $this->hasMany(CoverLetter::class);
    }

    public function businessCertificate(): HasMany {
        return $this->hasMany(BusinessCertificate::class);
    }

    public function unmarriedCertificate(): HasMany {
        return $this->hasMany(UnmarriedCertificate::class);
    }
}
