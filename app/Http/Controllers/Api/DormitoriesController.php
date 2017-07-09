<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Repositories\DormitoryRepositoryInterface;

class DormitoriesController extends ApiController
{
    public function lists()
    {
        return (app(DormitoryRepositoryInterface::class)->getDormitories(Auth::user())->toArray());
    }
}