<?php


namespace App\Http\Controllers\Api\Admin;


use App\Repositories\StudentRepositoryInterface;
use App\Transformers\UserTransformer;

class UsersController extends AdminController
{

    public function me()
    {
        return $this->response->item($this->guard()->user(), new UserTransformer());
    }

}
