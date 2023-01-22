<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model\EmployeeModel;
use App\Model\ShiftModel;
use App\Model\TubeDiameterModel;
use App\Model\TubeExcessModel;
use App\Model\TubeProductionModel;
use Nette;
use Nette\Application\UI\Form;


final class FormFactory
{
	use Nette\SmartObject;
    /**
     * @var TubeDiameterModel
     * @inject
     */
    public TubeDiameterModel $tubeDiameterModel;

    /**
     * @var EmployeeModel
     * @inject
     */
    public EmployeeModel $employeeModel;

    /**
     * @var TubeExcessModel
     * @inject
     */
    public TubeExcessModel $tubeExcessModel;

    /**
     * @var ShiftModel
     * @inject
     */
    public ShiftModel $shiftModel;

    /**
     * @var TubeProductionModel
     * @inject
     */
    public TubeProductionModel $tubeProductionModel;

    public function __construct(TubeDiameterModel $tubeDiameterModel, TubeExcessModel $tubeExcessModel, ShiftModel $shiftModel, TubeProductionModel $tubeProductionModel, EmployeeModel $employeeModel)
    {
        $this->tubeDiameterModel = $tubeDiameterModel;
        $this->tubeExcessModel = $tubeExcessModel;
        $this->shiftModel = $shiftModel;
        $this->tubeProductionModel = $tubeProductionModel;
        $this->employeeModel = $employeeModel;
    }
	public function create(): Form
	{
        return new Form;
	}
}
