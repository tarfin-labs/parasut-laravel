<?php

namespace TarfinLabs\Parasut\Tests;

use TarfinLabs\Parasut\Models\Product;
use TarfinLabs\Parasut\Tests\Mocks\ProductMock;
use TarfinLabs\Parasut\Repositories\ProductRepository;

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

    /** @test */
    public function user_can_create_a_new_product(): void
    {
        $product = factory(Product::class)
            ->states(['creation', 'response'])
            ->make();

        ProductMock::create($product);

        $ProductRepository = new ProductRepository();

        $productReturned = $ProductRepository->create($product);

        $this->assertInstanceOf(
            Product::class,
            $product
        );

        $this->assertEquals(
            $product->name,
            $productReturned->name
        );
    }

    /** @test */
    public function user_can_view_a_product(): void
    {
        $productId = ProductMock::find();

        $ProductRepository = new ProductRepository();

        $product = $ProductRepository->find($productId);

        $this->assertInstanceOf(
            Product::class,
            $product
        );

        $this->assertEquals(
            $productId,
            $product->id
        );
    }

    /** @test */
    public function user_can_edit_a_product(): void
    {
        $product = factory(Product::class)
            ->states(['creation', 'response'])
            ->make();

        ProductMock::create($product);
        $ProductRepository = new ProductRepository();
        $product = $ProductRepository->create($product);

        $newProduct = factory(Product::class)->make();
        $newProduct->id = $product->id;

        ProductMock::update($product);
        $updatedContact = $ProductRepository->update($newProduct);

        $this->assertInstanceOf(
            Product::class,
            $updatedContact
        );

        $this->assertEquals(
            $updatedContact->name,
            $newProduct->name
        );
    }

    /** @test */
    public function user_can_delete_a_product(): void
    {
        $product = factory(Product::class)
            ->states(['creation', 'response'])
            ->make();

        ProductMock::create($product);
        $ProductRepository = new ProductRepository();
        $product = $ProductRepository->create($product);

        ProductMock::delete($product);
        $result = $ProductRepository->delete($product);

        $this->assertTrue($result);
    }
}
