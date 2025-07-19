<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoverLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number', 'user_id', 'resident_id', 'name', 'place_of_birth', 'date_of_birth', 'gender', 'religion',
        'work_id', 'address', 'resident_number', 'family_number', 'certificate_category_id', 'status'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resident(): BelongsTo {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function work(): BelongsTo {
        return $this->belongsTo(Work::class, 'work_id');
    }

    public function certificateCategory(): BelongsTo {
        return $this->belongsTo(CertificateCategory::class, 'certificate_category_id');
    }

    public function coverLetterHistory(): HasMany {
        return $this->hasMany(CoverLetterHistory::class, 'certificate_id');
    }

    public function coverLetterList(): HasMany {
        return $this->hasMany(CoverLetterList::class);
    }

    public function domicileCertificate(): HasMany {
        return $this->hasMany(DomicileCertificate::class);
    }

    public function businessCertificate(): HasMany {
        return $this->hasMany(BusinessCertificate::class);
    }

    public function unmarriedCertificate(): HasMany {
        return $this->hasMany(UnmarriedCertificate::class);
    }
}
