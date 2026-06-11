<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $model)
    {
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByMobile(string $mobile): ?User
    {
        return $this->model->where('mobile', $mobile)->first();
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }
}
