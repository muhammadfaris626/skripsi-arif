<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'gender', 'religion', 'place_of_birth', 'date_of_birth', 'time_of_birth',
        'family_card_id', 'father_name', 'mother_name', 'address', 'child_from', 'give_birth_in',
        'birth_location', 'weight', 'birth_certificate'
    ];

    public function familyCard(): BelongsTo {
        return $this->belongsTo(FamilyCard::class, 'family_card_id');
    }
}
