<?php

namespace Christianhanggra\Bizzy\Permission\Repositories;

use Christianhanggra\Bizzy\Permission\Models\Employee;

class EmployeeRepository
{
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function find($id)
    {
        return $this->employee->find($id);
    }

    public function findByUserId($id)
    {
        return $this->employee->ofUserId(strtolower($id))->first();
    }
}