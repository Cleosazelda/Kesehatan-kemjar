<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'weight',
        'hypothesis_id'
    ];
    public function rule()
    {
        return $this->hasMany(Rule::class);
    }

    public function hypothesis()
    {
        return $this->belongsTo(Hypothesis::class);
    }
}
