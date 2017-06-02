<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class Portal extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'portal';
}