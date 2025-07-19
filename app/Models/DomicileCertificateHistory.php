<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomicileCertificateHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id', 'certificate_category_id', 'step', 'approver_id', 'status', 'is_active', 'description'
    ];

    public function certificate(): BelongsTo {
        return $this->belongsTo(DomicileCertificate::class, 'certificate_id');
    }

    public function certificateCategory(): BelongsTo {
        return $this->belongsTo(CertificateCategory::class, 'certificate_category_id');
    }

    public function approver(): BelongsTo {
        return $this->belongsTo(Position::class, 'approver_id');
    }
}
