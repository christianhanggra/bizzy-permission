<?php

namespace Christianhanggra\Bizzy\Permission\Repositories;

use Christianhanggra\Bizzy\Permission\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function findByUserId($id)
    {
        return $this->user->ofUserId(strtolower($id))->first();
    }
}