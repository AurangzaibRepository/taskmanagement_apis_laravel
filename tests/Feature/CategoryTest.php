<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_all(): void
    {
        $response = $this->getJson('/api/categories/all');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_category_listing(): void
    {
        $response = $this->postJson('/api/categories/listing', [
            'pageNumber' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_category_details(): void
    {
        $categoryId = Category::first()->id;
        $response = $this->getJson("/api/categories/{$categoryId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('data')
            );
    }

    public function test_category_add(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Category test',
            'description' => 'Test description',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->hasAll(['data', 'message'])
            );
    }

    public function test_category_update(): void
    {
        $response = $this->putJson('/api/categories/10', [
            'name' => 'Category updated',
            'description' => 'Updated description',
            'status' => 'Inactive',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }

    public function test_category_delete(): void
    {
        $categoryId = Category::latest('id')->first()->id;
        $response = $this->deleteJson("/api/categories/{$categoryId}");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }

    public function test_category_change_status(): void
    {
        $categoryId = Category::first()->id;
        $response = $this->postJson("/api/categories/change-status/{$categoryId}/Active");

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                ->has('message')
            );
    }
}
