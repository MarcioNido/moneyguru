<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{

    protected $fillable = ['bank_account_id', 'date', 'balance'];

    public $timestamps = false;

    /**
     * Balance / Bank Account Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }


    public static function updateBalance($data)
    {
        $amount = ($data['dc'] == 'D') ? $data['amount'] * -1 : $data['amount'];
        self::initBalance($data);

        DB::table('balances')
            ->where('bank_account_id', $data['bank_account_id'])
            ->where('date', '>=', $data['date'])
            ->increment('balance', $amount);

    }

    public static function reverseBalance($data)
    {
        $amount = ($data['dc'] == 'C') ? $data['amount'] * -1 : $data['amount'];
        self::initBalance($data);

        DB::table('balances')
            ->where('bank_account_id', $data['bank_account_id'])
            ->where('date', '>=', $data['date'])
            ->increment('balance', $amount);
    }

    protected static function initBalance($data)
    {

        $balance = self::getCurrentBalance($data);

        if (! $balance) {
            $balance = self::getPreviousBalance($data);
            self::createNewBalance($data, $balance);
        }

    }

    protected static function getCurrentBalance($data)
    {
        return Balance::where('bank_account_id', $data['bank_account_id'])
                        ->where('date', $data['date'])
                        ->first();

    }

    protected static function getPreviousBalance($data)
    {
        return Balance::where('bank_account_id', $data['bank_account_id'])
            ->where('date', '<', $data['date'])
            ->orderBy('date', 'desc')
            ->limit(1)
            ->first();
    }

    protected static function createNewBalance($data, $balance)
    {
        Balance::create([
            'bank_account_id' => $data['bank_account_id'],
            'date' => $data['date'],
            'balance' => $balance ? $balance->balance : 0
        ]);
    }

}
