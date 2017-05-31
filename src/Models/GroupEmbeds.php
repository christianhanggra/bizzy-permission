<?php

namespace Christianhanggra\Bizzy\Permission\Models;

use Moloquent\Eloquent\Model;

class GroupEmbeds extends Model
{
    public function group()
    {
    	return $this->hasOne(Group::class, '_id', 'id');
    }
}