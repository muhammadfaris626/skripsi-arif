<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnmarriedCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover_letter_id', 'request_number', 'user_id', 'resident_id', 'name', 'resident_number',
        'place_of_birth', 'date_of_birth', 'gender', 'marital_status', 'religion', 'work_id',
        'address', 'description', 'validity_period'
    ];

    public function coverLetter(): BelongsTo {
        return $this->belongsTo(CoverLetter::class, 'cover_letter_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resident(): BelongsTo {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function work(): BelongsTo {
        return $this->belongsTo(Work::class, 'work_id');
    }

    public function unmarriedCertificateHistory(): HasMany {
        return $this->hasMany(UnmarriedCertificateHistory::class);
    }
}
