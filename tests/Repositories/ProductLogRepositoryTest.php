<?php namespace Tests\Repositories;

use App\Models\ProductLog;
use App\Repositories\ProductLogRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProductLogRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductLogRepository
     */
    protected $productLogRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->productLogRepo = \App::make(ProductLogRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_product_log()
    {
        $productLog = ProductLog::factory()->make()->toArray();

        $createdProductLog = $this->productLogRepo->create($productLog);

        $createdProductLog = $createdProductLog->toArray();
        $this->assertArrayHasKey('id', $createdProductLog);
        $this->assertNotNull($createdProductLog['id'], 'Created ProductLog must have id specified');
        $this->assertNotNull(ProductLog::find($createdProductLog['id']), 'ProductLog with given id must be in DB');
        $this->assertModelData($productLog, $createdProductLog);
    }

    /**
     * @test read
     */
    public function test_read_product_log()
    {
        $productLog = ProductLog::factory()->create();

        $dbProductLog = $this->productLogRepo->find($productLog->id);

        $dbProductLog = $dbProductLog->toArray();
        $this->assertModelData($productLog->toArray(), $dbProductLog);
    }

    /**
     * @test update
     */
    public function test_update_product_log()
    {
        $productLog = ProductLog::factory()->create();
        $fakeProductLog = ProductLog::factory()->make()->toArray();

        $updatedProductLog = $this->productLogRepo->update($fakeProductLog, $productLog->id);

        $this->assertModelData($fakeProductLog, $updatedProductLog->toArray());
        $dbProductLog = $this->productLogRepo->find($productLog->id);
        $this->assertModelData($fakeProductLog, $dbProductLog->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_product_log()
    {
        $productLog = ProductLog::factory()->create();

        $resp = $this->productLogRepo->delete($productLog->id);

        $this->assertTrue($resp);
        $this->assertNull(ProductLog::find($productLog->id), 'ProductLog should not exist in DB');
    }
}
