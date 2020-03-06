<?php

namespace Tests\Feature;
namespace Tests;

use App\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    public function testPostCreateProducts()
    {
        $product = factory(Products::class)->create();
        $response = $this->post('/products',[$product]);
        $response->assertStatus(419);
    }
}
