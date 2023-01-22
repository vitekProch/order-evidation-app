<?php

namespace App\Model;

use App\Repository\TubeDiameterRepository;

class TubeDiameterModel
{
    /**
     * @var TubeDiameterRepository
     * @inject
     */
    public TubeDiameterRepository $tubeDiameterRepository;

    public function __construct(TubeDiameterRepository $tubeDiameterRepository)
    {
        $this->tubeDiameterRepository = $tubeDiameterRepository;
    }
    public function getDiameters(): array
    {
        return $this->tubeDiameterRepository->getDiameters();
    }
}