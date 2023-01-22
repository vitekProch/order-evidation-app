<?php

namespace App\Repository;

class ShiftRepository extends BaseRepository
{
    public function getActiveShift($shift_id): \Nette\Database\ResultSet
    {
        return $this->database->query('SELECT shift_name FROM shift WHERE shift_id = ?', $shift_id);
    }
    public function getShiftByName($shift_name): ?\Nette\Database\Row
    {
      return $this->database->query('SELECT shift_id FROM shift WHERE shift_name = ?', $shift_name)->fetch();
    }
}
