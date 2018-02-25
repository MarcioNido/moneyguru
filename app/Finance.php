<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'date'];

    protected $fillable = [
        'bank_account_id',
        'category_id',
        'description',
        'dc',
        'date',
        'amount'
    ];

    public static $validationRules = [
        'bank_account_id'   => 'int|required',
        'category_id'       => 'int|required',
        'date'              => 'date|required',
        'description'       => 'string|required|max:255',
        'dc'                => 'required',
        'amount'            => 'numeric|required'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }


    public function save(array $options = [])
    {
        return parent::save($options);
    }


}
