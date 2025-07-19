<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalSetting extends Model
{
    use HasFactory;

    protected $fillable = ['certificate_category_id', 'position_id', 'step', 'approver_1', 'approver_2', 'approver_3', 'approver_4', 'approver_5'];

    public function certificateCategory(): BelongsTo {
        return $this->belongsTo(CertificateCategory::class, 'certificate_category_id');
    }

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class, ['position_id', 'approver_1', 'approver_2', 'approver_3', 'approver_4', 'approver_5']);
    }

}
