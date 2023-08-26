<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [

        'category_id',
        'name',
        'slug',
        'status',
    ];

    public function advertisements() {
        return $this->hasMany(Advertisement::class);
    }
    
}
