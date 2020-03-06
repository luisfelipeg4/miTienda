<?php

namespace Tests\Feature;
namespace Tests;

use App\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    public function testPostProducts()
    {
        $product = factory(Products::class)->create();
        $response = $this->post('/products',[$product]);
        $response->assertStatus(200);
    }
    public function testGetProducts()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }
    public function testDeleteroducts()
    {
        $this->withoutMiddleware();
        $response = $this->delete('/products/4');
        $response->assertStatus(200);
    }
    public function testUpdateProducts()
    {
        $response = $this->patch('/products/1',['_token' => csrf_token()]);
        $response->assertStatus(200);
    }
}
