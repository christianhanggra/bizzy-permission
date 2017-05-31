<?php

namespace Christianhanggra\Bizzy\Select\Permission\Models;

use Moloquent\Eloquent\Model;

class PermissionEmbeds extends Model
{
    public function permission()
    {
    	return $this->hasOne(Permission::class, '_id', 'id');
    }
}