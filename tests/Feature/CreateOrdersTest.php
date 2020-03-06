<?php

namespace Tests\Feature;
namespace Tests;

use App\Orders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrdersTest extends TestCase
{
    public function testPostCreateOrders()
    {
        $order = factory(Orders::class)->create();
        $response = $this->post('/orders',[$order]);
        $response->assertStatus(419);
    }
}
