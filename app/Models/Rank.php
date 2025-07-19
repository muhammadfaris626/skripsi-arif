<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rank extends Model
{
    use HasFactory;

    protected $fillable = ['rank_name'];

    public function employee(): HasMany {
        return $this->hasMany(Employee::class);
    }
}
