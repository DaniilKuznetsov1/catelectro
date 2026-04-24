<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorys extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cat_id',
        'catname',
        'catdescription',
    ];

    protected $primaryKey = 'cat_id';
    protected $table = 'categorys';
}
