<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class ProductAccess extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'product_access';
}