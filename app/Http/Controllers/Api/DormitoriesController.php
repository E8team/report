<?php

namespace App\Http\Controllers\Api;

use App\Transformers\DormitoryTransformer;
use Auth;
use App\Repositories\DormitoryRepositoryInterface;

class DormitoriesController extends ApiController
{
    public function lists()
    {
        $student = Auth::user();
        $dormitories = app(DormitoryRepositoryInterface::class)->getDormitories($student);
        return $this->response->collection($dormitories, new DormitoryTransformer());
    }
}