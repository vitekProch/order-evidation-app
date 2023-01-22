<?php

namespace App\Model;
use App\Repository\TubeExcessRepository;
use Nette\Database\ResultSet;
use Nette\Database\Row;

class TubeExcessModel
{
    /**
     * @var TubeExcessRepository
     * @inject
     */
    public TubeExcessRepository $tubeExcessRepository;

    public function __construct(TubeExcessRepository $tubeExcessRepository)
    {
        $this->tubeExcessRepository = $tubeExcessRepository;
    }

    public function getExcess(): ResultSet
    {
        return $this->tubeExcessRepository->getExcess();
    }

    public function findExcess($order_id): ?Row
    {
        return $this->tubeExcessRepository->findExcess($order_id);
    }
    public function insertExcess($order_id, $quantity, $diameter_excess)
    {
        $this->tubeExcessRepository->insertExcess($order_id, $quantity, $diameter_excess);
    }

    public function updateExcess($order_id, $quantity, $diameters)
    {
        $this->tubeExcessRepository->updateExcess($order_id, $quantity, $diameters);
    }

    public function newExcessQuantity($order_id, $quantity)
    {
        $this->tubeExcessRepository->newExcessQuantity($order_id,$quantity);
    }

    public function checkExcess($order_id): ?Row
    {
        return $this->tubeExcessRepository->checkExcess($order_id);
    }
    public function deleteExcess($excessId)
    {
        $this->tubeExcessRepository->deleteExcess($excessId);
    }
    public function newExcess($id, $material_id, $quantity, $diameter)
    {
        $this->tubeExcessRepository->newExcess($id, $material_id, $quantity, $diameter);
    }
    public function getExcessById($material_id): ?Row
    {
        return $this->tubeExcessRepository->getExcessById($material_id);
    }

}