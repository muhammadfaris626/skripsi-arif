<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateCategory extends Model
{
    use HasFactory;

    protected $fillable = ['certificate_category_name'];

    public function approvalSetting(): HasMany {
        return $this->hasMany(ApprovalSetting::class);
    }

    public function coverLetter(): HasMany {
        return $this->hasMany(CoverLetter::class);
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
