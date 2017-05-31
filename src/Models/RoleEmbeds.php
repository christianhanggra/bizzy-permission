<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class RoleEmbeds extends Model
{
    public function role()
    {
    	return $this->hasOne(Role::class, '_id', 'id');
    }

    public function groups()
    {
    	return $this->embedsMany(GroupEmbeds::class);
    }

    public function products()
    {
    	return $this->embedsMany(ProductAccessEmbeds::class);
    }
}