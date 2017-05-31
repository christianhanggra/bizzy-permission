<?php

namespace Christianhanggra\Bizzy\Select\Permission\Models;

use Moloquent\Eloquent\Model;

class ProductAccessEmbeds extends Model
{
    public function product()
    {
    	return $this->hasOne(ProductAccess::class, '_id', 'id');
    }
}