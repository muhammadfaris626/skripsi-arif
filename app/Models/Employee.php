<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number', 'name', 'gender', 'address', 'phone', 'effective_date', 'position_id',
        'rank_id', 'employee_status', 'blood_group', 'education_id'
    ];

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function rank(): BelongsTo {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function education(): BelongsTo {
        return $this->belongsTo(Education::class, 'education_id');
    }
}
