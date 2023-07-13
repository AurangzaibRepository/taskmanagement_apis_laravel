<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest_copy extends TestCase
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
        $response = $this->putJson('/api/categories/6', [
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

    public function test_category_delete(): void
    {
        $response = $this->deleteJson('/api/categories/8');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_category_change_status(): void
    {
        $response = $this->postJson('/api/categories/change-status/6/Active');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }
}
