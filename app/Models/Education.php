<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['education_name'];

    public function employee(): HasMany {
        return $this->hasMany(Employee::class);
    }

    public function resident(): HasMany {
        return $this->hasMany(Resident::class);
    }
}
