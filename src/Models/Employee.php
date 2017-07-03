<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'employee';

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