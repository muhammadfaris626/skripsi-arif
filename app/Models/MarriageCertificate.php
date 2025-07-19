<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarriageCertificate extends Model
{
    use HasFactory;

    protected $fillable = ['request_number', 'user_id', 'name', 'place_of_birth', 'date_of_birth', 'work_id', 'couple_name', 'partner_address', 'guardian_name', 'wedding_date', 'name_of_the_chief', 'bride_price', 'witness_name'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function work(): BelongsTo {
        return $this->belongsTo(Work::class, 'work_id');
    }

    public function marriageCertificateHistory(): HasMany {
        return $this->hasMany(MarriageCertificateHistory::class);
    }
}
