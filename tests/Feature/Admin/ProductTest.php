<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Products\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_delete_product_variant()
    {

        $this->actingAsAdmin();

        $mainProduct = create(Product::class);

        create(Product::class, ["parent_id" => $mainProduct->id]);

        $response = $this->delete('api/admin/products/' . $mainProduct->id);
        // $result = $response->json();

        // $product = Product::withTrashed()->find($mainProduct->id);

        $this->assertSoftDeleted('products', [
            "id" => $mainProduct->id
        ]);
    }
}
