<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class Group extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'group';

    public function product()
    {
    	return $this->belongsTo(ProductAccess::class, 'product_access_id', '_id');
    }
}