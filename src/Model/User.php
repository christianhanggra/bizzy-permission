<?php

namespace Christianhanggra\Bizzy\Select\Permission;

use Moloquent\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb_select';
    protected $collection = 'user';
}