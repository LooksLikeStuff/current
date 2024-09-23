<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sector_id',
    ];

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

}
