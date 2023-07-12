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
}
