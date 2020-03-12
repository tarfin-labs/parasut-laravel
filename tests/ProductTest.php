<?php

namespace TarfinLabs\Parasut\Tests;

class ProductTest extends TestCase
{
    /** @test */
    public function user_can_list_products(): void
    {
        ProductMock::all();

        $productRepository = new ProductRepository();

        $products = $productRepository->all();

        $this->assertNotNull(Product::all());
        $this->assertInstanceOf(Product::class, $products->first());
    }
}
