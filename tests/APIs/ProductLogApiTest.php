<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProductLog;

class ProductLogApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_product_log()
    {
        $productLog = ProductLog::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/product_logs', $productLog
        );

        $this->assertApiResponse($productLog);
    }

    /**
     * @test
     */
    public function test_read_product_log()
    {
        $productLog = ProductLog::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/product_logs/'.$productLog->id
        );

        $this->assertApiResponse($productLog->toArray());
    }

    /**
     * @test
     */
    public function test_update_product_log()
    {
        $productLog = ProductLog::factory()->create();
        $editedProductLog = ProductLog::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/product_logs/'.$productLog->id,
            $editedProductLog
        );

        $this->assertApiResponse($editedProductLog);
    }

    /**
     * @test
     */
    public function test_delete_product_log()
    {
        $productLog = ProductLog::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/product_logs/'.$productLog->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/product_logs/'.$productLog->id
        );

        $this->response->assertStatus(404);
    }
}
