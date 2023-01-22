<?php

namespace App\Presenters;

use App\Forms\ProductionEditFormFactory;
use Nette;

use App\Model\EmployeeModel;
use App\Model\TubeDiameterModel;
use App\Model\TubeExcessModel;
use App\Model\TubeProductionModel;
use App\Model\SignModel;
use App\Model\ShiftModel;

use Nette\Application\UI\Form;
use App\Forms\SearchFormFactory;


class BasePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var TubeProductionModel
     * @inject
     */
    public TubeProductionModel $tubeProductionModel;

    /**
     * @var EmployeeModel
     * @inject
     */
    public EmployeeModel $employeeModel;

    /**
     * @var TubeDiameterModel
     * @inject
     */
    public TubeDiameterModel $tubeDiameterModel;

    /**
     * @var TubeExcessModel
     * @inject
     */
    public TubeExcessModel $tubeExcessModel;

    /**
     * @var SignModel
     * @inject
     */
    public SignModel $signModel;

    /**
     * @var ShiftModel
     * @inject
     */
    public ShiftModel $shiftModel;

    /**
     * @var SearchFormFactory
     * @inject
     */
    public SearchFormFactory $searchFormFactory;

    /**
     * @var ProductionEditFormFactory
     * @inject
     */
    public ProductionEditFormFactory $productionEditFormFactory;

    protected function createComponentEditForm(): Form
    {
        return $this->productionEditFormFactory->create();
    }


    protected function createComponentSearchForm(): Form
    {
        return $this->searchFormFactory->create();
    }

    public function actionEdit(int $id, $position): void
    {
        $order_value = $this->tubeProductionModel->getOrderById()->get($id);
        if (!$order_value) {
            $this->error('Uživatel nebyl nalezen');
        }
        if ($this->user->id == $order_value->toArray()["employee_id"]) {
            $this['editForm']->setValues(array(
                'back_to' => $position
            ));
            $this['editForm']->setDefaults($order_value->toArray());
        }
        else{
            $this->flashMessage("Nemáte oprávění upravit tuto zakázku","error");
        }
    }
    public function handleDelete(int $id)
    {
        $this->tubeProductionModel->deleteRecord($id);
        $this->flashMessage('Zakázka byla odstraněna.', 'success');
        $this->redirect('TubeProduction:production');
    }

}