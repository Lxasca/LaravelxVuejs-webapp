<?php

namespace App\Models;

use App\Models\Vocabularies;
use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    public function vocabulary() {
        return $this->belongsTo(Vocabularies::class, 'vocabulary_id', 'id');
    }

}
