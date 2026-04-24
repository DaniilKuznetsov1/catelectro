<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorys extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'catname',
        'catdescription',
    ];

    protected $primaryKey = 'cat_id';
    protected $table = 'categorys';
}
