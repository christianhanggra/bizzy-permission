<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class Permission extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'permission';
}