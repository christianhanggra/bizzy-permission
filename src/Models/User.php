<?php

namespace Christianhanggra\Bizzy\Select\Permission\Models;

use Moloquent\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'user';

    public function scopeOfUserId($query, $id)
    {
    	return $query->where('user_id', $id);
    }

    public function roles()
    {
    	return $this->embedsMany(RoleEmbeds::class);
    }

    public function permissions()
    {
    	return $this->embedsMany(PermissionEmbeds::class);
    }
}