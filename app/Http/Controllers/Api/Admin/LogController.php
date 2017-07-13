<?php

namespace App\Http\Controllers\Api\Admin;


use App\Repositories\LogRepositoryInterface;
use App\Transformers\LogTransformer;

class LogController extends AdminController
{
    public function lists(LogRepositoryInterface $logRepository, $departmentId=null)
    {
        $this->validatePermission('admin.get_logs');
        $user = $this->guard()->user();
        if(!$user->isSuperAdmin() || is_null($departmentId))
            $departmentId = $user->getDepartmentId();
        return $this->response->collection($logRepository->getLogs($departmentId), new LogTransformer());
    }
}
