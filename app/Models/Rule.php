<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'evidence_id',
        'hypothesis_id',
        'weight'
    ];

    public function evidence()
    {
        return $this->belongsTo(Evidence::class);
    }
    public function hypothesis()
    {
        return $this->belongsTo(Hypothesis::class);
    }
    
}