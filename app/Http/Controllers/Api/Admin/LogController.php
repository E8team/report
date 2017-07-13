<?php

namespace App\Http\Controllers\Api\Admin;


use App\Repositories\LogRepositoryInterface;
use App\Transformers\LogTransformer;

class LogController extends AdminController
{
    public function lists(LogRepositoryInterface $logRepository)
    {
        $this->validatePermission('admin.get_logs');
        return $this->response->collection($logRepository->getLogs(), new LogTransformer());
    }
}