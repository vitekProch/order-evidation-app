<?php

namespace App\Repository;


class EmployeeRepository extends BaseRepository
{
    public function insertShift($shift_id, $employee_id)
    {
        $this->database->query('UPDATE employee SET shift_id = ? WHERE employee_id = ?', $shift_id, $employee_id);
    }

    public function getEmployeeName($employee_id)
    {
        return $this->database->query('SELECT name FROM employee WHERE employee_id = ?', $employee_id)->fetchField();
    }
}