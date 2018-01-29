<?php

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_list_all_categories()
    {
        $category = factory(Category::class)->create();

        $this->json('GET', 'api/v1/categories')
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name]);
    }

}
