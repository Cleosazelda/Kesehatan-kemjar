<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypothesisImage extends Model
{
    use HasFactory;

    protected $fillable = ['hypothesis_id', 'image_path'];

    public function hypothesis()
    {
        return $this->belongsTo(Hypothesis::class);
    }
}
