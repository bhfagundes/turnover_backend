<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductLogAPIRequest;
use App\Http\Requests\API\UpdateProductLogAPIRequest;
use App\Models\ProductLog;
use App\Repositories\ProductLogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductLogResource;
use Response;

/**
 * Class ProductLogController
 * @package App\Http\Controllers\API
 */

class ProductLogAPIController extends AppBaseController
{
    /** @var  ProductLogRepository */
    private $productLogRepository;

    public function __construct(ProductLogRepository $productLogRepo)
    {
        $this->productLogRepository = $productLogRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/productLogs",
     *      summary="Get a listing of the ProductLogs.",
     *      tags={"ProductLog"},
     *      description="Get all ProductLogs",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/ProductLog")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $productLogs = $this->productLogRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ProductLogResource::collection($productLogs), 'Product Logs retrieved successfully');
    }

    /**
     * @param CreateProductLogAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/productLogs",
     *      summary="Store a newly created ProductLog in storage",
     *      tags={"ProductLog"},
     *      description="Store ProductLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductLog that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductLog")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductLogAPIRequest $request)
    {
        $input = $request->all();

        $productLog = $this->productLogRepository->create($input);

        return $this->sendResponse(new ProductLogResource($productLog), 'Product Log saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/productLogs/{id}",
     *      summary="Display the specified ProductLog",
     *      tags={"ProductLog"},
     *      description="Get ProductLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {

        /** @var ProductLog $productLog */
        $productLog = ProductLog::where('id_product',$id)->orderBy('id','DESC')->get();
        return $this->sendResponse($productLog, 'Product Log retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProductLogAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/productLogs/{id}",
     *      summary="Update the specified ProductLog in storage",
     *      tags={"ProductLog"},
     *      description="Update ProductLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductLog that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductLog")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ProductLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductLogAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductLog $productLog */
        $productLog = $this->productLogRepository->find($id);

        if (empty($productLog)) {
            return $this->sendError('Product Log not found');
        }

        $productLog = $this->productLogRepository->update($input, $id);

        return $this->sendResponse(new ProductLogResource($productLog), 'ProductLog updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/productLogs/{id}",
     *      summary="Remove the specified ProductLog from storage",
     *      tags={"ProductLog"},
     *      description="Delete ProductLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var ProductLog $productLog */
        $productLog = $this->productLogRepository->find($id);

        if (empty($productLog)) {
            return $this->sendError('Product Log not found');
        }

        $productLog->delete();

        return $this->sendSuccess('Product Log deleted successfully');
    }
}
