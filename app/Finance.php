<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'bank_account_id',
        'category_id',
        'description',
        'dc',
        'date',
        'amount'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }


}
