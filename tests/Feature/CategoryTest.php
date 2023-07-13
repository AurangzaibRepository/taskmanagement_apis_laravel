<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_all(): void
    {
        $response = $this->getJson('/api/categories/all');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_category_listing(): void
    {
        $response = $this->postJson('/api/categories/listing', [
            'pageNumber' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_category_details(): void
    {
        $response = $this->getJson('/api/categories/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_category_add(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Category test',
            'description' => 'Test description',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_category_update(): void
    {
        $response = $this->put('/api/categories/6', [
            'name' => 'Category updated',
            'description' => 'Updated description',
            'status' => 'Inactive',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }
}
