<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductLogRequest;
use App\Http\Requests\UpdateProductLogRequest;
use App\Repositories\ProductLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ProductLogController extends AppBaseController
{
    /** @var  ProductLogRepository */
    private $productLogRepository;

    public function __construct(ProductLogRepository $productLogRepo)
    {
        $this->productLogRepository = $productLogRepo;
    }

    /**
     * Display a listing of the ProductLog.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $productLogs = $this->productLogRepository->all();

        return view('product_logs.index')
            ->with('productLogs', $productLogs);
    }

    /**
     * Show the form for creating a new ProductLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_logs.create');
    }

    /**
     * Store a newly created ProductLog in storage.
     *
     * @param CreateProductLogRequest $request
     *
     * @return Response
     */
    public function store(CreateProductLogRequest $request)
    {
        $input = $request->all();

        $productLog = $this->productLogRepository->create($input);

        Flash::success('Product Log saved successfully.');

        return redirect(route('productLogs.index'));
    }

    /**
     * Display the specified ProductLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productLog = $this->productLogRepository->find($id);

        if (empty($productLog)) {
            Flash::error('Product Log not found');

            return redirect(route('productLogs.index'));
        }

        return view('product_logs.show')->with('productLog', $productLog);
    }

    /**
     * Show the form for editing the specified ProductLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productLog = $this->productLogRepository->find($id);

        if (empty($productLog)) {
            Flash::error('Product Log not found');

            return redirect(route('productLogs.index'));
        }

        return view('product_logs.edit')->with('productLog', $productLog);
    }

    /**
     * Update the specified ProductLog in storage.
     *
     * @param int $id
     * @param UpdateProductLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductLogRequest $request)
    {
        $productLog = $this->productLogRepository->find($id);

        if (empty($productLog)) {
            Flash::error('Product Log not found');

            return redirect(route('productLogs.index'));
        }

        $productLog = $this->productLogRepository->update($request->all(), $id);

        Flash::success('Product Log updated successfully.');

        return redirect(route('productLogs.index'));
    }

    /**
     * Remove the specified ProductLog from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productLog = $this->productLogRepository->find($id);

        if (empty($productLog)) {
            Flash::error('Product Log not found');

            return redirect(route('productLogs.index'));
        }

        $this->productLogRepository->delete($id);

        Flash::success('Product Log deleted successfully.');

        return redirect(route('productLogs.index'));
    }
}
