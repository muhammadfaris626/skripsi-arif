<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoverLetterList extends Model
{
    use HasFactory;

    protected $fillable = ['certificate_id', 'file_name', 'file_upload'];

    public function certificate(): BelongsTo {
        return $this->belongsTo(CoverLetter::class, 'certificate_id');
    }
}
