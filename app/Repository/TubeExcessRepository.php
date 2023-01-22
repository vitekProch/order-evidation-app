<?php

namespace App\Repository;

use Nette\Database\ResultSet;
use Nette\Database\Row;

class TubeExcessRepository extends BaseRepository
{
    CONST TABLE_NAME = 'tube_excess';

    public function getExcessById($material_id): ?Row
    {
        return $this->database->query('SELECT * FROM tube_excess WHERE material_id = ?', $material_id)->fetch();
    }
    public function getExcess(): ResultSet
    {
        return $this->database->query('SELECT material_id,quantity,diameter FROM `tube_excess` INNER JOIN tube_diameter ON tube_excess.diameter_id = tube_diameter.diameter_id ORDER BY tube_diameter.diameter_id');
    }

    public function findExcess($material_id): ?Row
    {
        return $this->database->query('SELECT material_id, quantity, diameter FROM tube_excess INNER JOIN tube_diameter ON tube_excess.diameter_id = tube_diameter.diameter_id WHERE material_id = ?', $material_id)->fetch();
    }
    public function insertExcess($material_id, $quantity, $diameter_excess)
    {
        $this->database->table(self::TABLE_NAME)->insert([
            'material_id' => $material_id,
            'quantity' => $quantity,
            'diameter_id' => $diameter_excess,
        ]);
    }

    public function updateExcess($material_id, $quantity, $diameters)
    {
        $this->database->query('
            update tube_excess
            set quantity = quantity + ?, diameter_id = ?
            WHERE material_id = ?', $quantity, $diameters, $material_id);
    }
    public function deleteExcess($excess_id)
    {
        $this->database->query('DELETE FROM tube_excess WHERE material_id = ?',$excess_id);
    }

    public function newExcessQuantity($material_id, $quantity)
    {
        $this->database->query('
            update tube_excess
            set quantity = ?
            WHERE material_id = ?', $quantity, $material_id);
    }
    public function newExcess($id, $material_id, $quantity, $diameter)
    {
        $this->database->query('
            update tube_excess
            set material_id = ?, quantity = ?, diameter_id = ?
            WHERE id = ?', $material_id, $quantity, $diameter, $id);
    }

    public function checkExcess($material_id): ?Row
    {
        return $this->database->query('SELECT material_id FROM tube_excess WHERE material_id = ?', $material_id)->fetch();
    }
}