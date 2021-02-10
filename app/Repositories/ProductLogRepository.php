<?php

namespace App\Repositories;

use App\Models\ProductLog;
use App\Repositories\BaseRepository;

/**
 * Class ProductLogRepository
 * @package App\Repositories
 * @version February 10, 2021, 3:48 pm UTC
*/

class ProductLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_product',
        'quantity',
        'price'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductLog::class;
    }
}
