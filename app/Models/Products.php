<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'photo',
        'price',
        'valprice',
        'category_id',
    ];

    protected $table = 'products';
}
