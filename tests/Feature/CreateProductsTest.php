<?php

namespace Tests\Feature;
namespace Tests;

use App\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function postCreateProductsTest()
    {
        $product = factory(Products::class)->create();
        $response = $this->post(route('products.store'),$product);
        print_r("hola");
        $this->assertDatabaseHas('products',$product);
        $response->assertStatus(200);
    }
}
