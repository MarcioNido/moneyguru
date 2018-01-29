<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{

    /**
     * Balance / Bank Account Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

}
