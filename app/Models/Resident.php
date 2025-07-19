<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_card_id', 'resident_name', 'resident_number', 'gender', 'place_of_birth',
        'date_of_birth', 'religion', 'education_id', 'work_id', 'blood_group', 'marital_status',
        'wedding_date', 'relationship_status', 'citizenship', 'paspor_number', 'kitap_number',
        'father_name', 'mother_name', 'phone_number'
    ];

    public function familyCard(): BelongsTo {
        return $this->belongsTo(FamilyCard::class, 'family_card_id');
    }

    public function education(): BelongsTo {
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function work(): BelongsTo {
        return $this->belongsTo(Work::class, 'work_id');
    }

    public function coverLetter(): HasMany {
        return $this->hasMany(CoverLetter::class);
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
