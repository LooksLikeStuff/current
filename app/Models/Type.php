<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * type of ticker
 */
class Type extends Model
{
    protected $fillable = [
        'name',
    ];

    use HasFactory;
}
