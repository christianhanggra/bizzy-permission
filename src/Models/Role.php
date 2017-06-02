<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'role';

    public function permissions()
    {
    	return $this->embedsMany(PermissionEmbeds::class);
    }
}