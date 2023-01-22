<?php

namespace App\Model;

use App\Repository\ShiftRepository;
use Nette\Database\Row;

class ShiftModel
{
    /**
     * @var ShiftRepository
     * @inject
     */
    public ShiftRepository $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function getShiftByName($shift_name): ?Row
    {
        return $this->shiftRepository->getShiftByName($shift_name);
    }
}
