<?php

namespace App\Repository;

class TubeDiameterRepository extends BaseRepository
{
    public function getDiameters(): array
    {
        return $this->database->query('SELECT diameter FROM tube_diameter'
        )->fetchPairs();
    }
}