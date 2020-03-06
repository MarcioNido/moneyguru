<?php

namespace Tests\Feature;

use App\BankAccount;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BankAccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_run_tests()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function a_user_can_list_all_bank_accounts()
    {

        $bankAccount = factory(BankAccount::class)->create();

        $this->json('GET', 'api/v1/bank-accounts')
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $bankAccount->name]);

    }

//    /** @test */
//    public function a_user_can_update_a_bank_account()
//    {
//
//    }

}
