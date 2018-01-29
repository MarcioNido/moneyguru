<?php

namespace Tests\Feature;

use App\Finance;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_read_the_finances_collection()
    {
        $finance = factory(Finance::class)->create();

        $this->json('GET', 'api/v1/finances')
            ->assertStatus(200)
            ->assertJsonFragment(['description' => $finance->description]);
    }
}
