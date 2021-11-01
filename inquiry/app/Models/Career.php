<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Career extends Model
{
    use SoftDeletes;

    public $table = 'careers';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'file',
    ];

    
}
