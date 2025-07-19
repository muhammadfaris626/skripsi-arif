<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['position_name'];

    public function employee(): HasMany {
        return $this->hasMany(Employee::class);
    }

    public function approvalSetting(): HasMany {
        return $this->hasMany(ApprovalSetting::class);
    }

    public function coverLetterHistory(): HasMany {
        return $this->hasMany(CoverLetterHistory::class);
    }

    public function domicileCertificateHistory(): HasMany {
        return $this->hasMany(DomicileCertificateHistory::class);
    }

    public function businessCertificateHistory(): HasMany {
        return $this->hasMany(BusinessCertificateHistory::class);
    }

    public function unmarriedCertificateHistory(): HasMany {
        return $this->hasMany(UnmarriedCertificateHistory::class);
    }
}
