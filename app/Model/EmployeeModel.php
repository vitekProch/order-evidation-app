<?php

namespace App\Model;

use App\Repository\EmployeeRepository;
use App\Repository\ShiftRepository;

class EmployeeModel
{
    /**
     * @var EmployeeRepository
     * @inject
     */
    public EmployeeRepository $employeeRepository;

    /**
     * @var ShiftRepository
     * @inject
     */
    public ShiftRepository $shiftRepository;

    public function __construct(EmployeeRepository $employeeRepository, ShiftRepository $shiftRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->shiftRepository = $shiftRepository;
    }
    public function insertShift($shift_id, $employee_id)
    {
        $shift_name = $this->shiftRepository->getActiveShift($shift_id)->fetch();
        $this->employeeRepository->insertShift($shift_name->shift_name, $employee_id);
    }
    public function getEmployeeName($employee_id)
    {
        return $this->employeeRepository->getEmployeeName($employee_id);
    }
}