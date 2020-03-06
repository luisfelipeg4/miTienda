<?php

namespace Tests\Feature;

namespace Tests;

use App\Orders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;
    public function testPostOrders()
    {
        $order = factory(Orders::class)->create();
        $response = $this->post('/orders', [$order]);
        $response->assertStatus(200);
    }
    public function testGetOrders()
    {
        $response = $this->get('/orders');
        $response->assertStatus(200);
    }
    public function testUpdateOrders()
    {
        $response = $this->patch('/orders/1',['_token' => csrf_token()]);
        $response->assertStatus(200);
    }
    
}
