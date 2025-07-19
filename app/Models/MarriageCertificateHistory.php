<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarriageCertificateHistory extends Model
{
    use HasFactory;

    protected $fillable = ['certificate_id', 'approval_category', 'step', 'approver_id', 'status', 'is_active'];

    public function certificate(): BelongsTo {
        return $this->belongsTo(MarriageCertificate::class, 'certificate_id');
    }

    public function approver(): BelongsTo {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
