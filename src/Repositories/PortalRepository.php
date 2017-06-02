<?php

namespace Christianhanggra\Bizzy\Permission\Repositories;

use Christianhanggra\Bizzy\Permission\Models\Portal;

class PortalRepository
{
    protected $portal;

    public function __construct(Portal $portal)
    {
        $this->portal = $portal;
    }

    public function find($id)
    {
        return $this->portal->find($id);
    }
}