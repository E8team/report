<?php
namespace App\Repositories;

use App\Models\User;

interface DormitoryRepositoryInterface
{
    public function getDormitories(User $user);
}