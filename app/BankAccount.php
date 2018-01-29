<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;

    public static $validationRules = [
        'name' => 'required'
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

}
