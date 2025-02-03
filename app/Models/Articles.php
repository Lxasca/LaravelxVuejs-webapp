<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_french',
        'content',
        'content_french',
        'content_2',
        'content_2_french',
    ];

    public $timestamps = true;
}
