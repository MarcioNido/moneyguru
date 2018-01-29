<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public static $validationRules = [
        'level1' => 'integer|required',
        'level2' => 'integer|nullable',
        'name' => 'string|required|max:50',
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = ['level1', 'level2', 'level3', 'name'];

}
