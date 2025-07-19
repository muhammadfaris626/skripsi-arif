<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyCard extends Model
{
    use HasFactory;

    protected $fillable = ['family_number', 'name', 'address', 'rt', 'rw', 'province_id', 'regency_id', 'district_id', 'village_id', 'postal_code'];

    public function resident(): HasMany {
        return $this->hasMany(Resident::class);
    }

    public function birthCertificate(): HasMany {
        return $this->hasMany(BirthCertificate::class);
    }
}
