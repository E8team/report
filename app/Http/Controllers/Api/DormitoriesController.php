<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Repositories\DormitoryRepositoryInterface;

class DormitoriesController extends ApiController
{
    public function lists()
    {
        app(DormitoryRepositoryInterface::class)->getDormitories(User::find(1));
    }
}