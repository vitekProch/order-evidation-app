<?php

namespace App\Presenters;

use App\Forms\ExcessEditFormFactory;
use App\Forms\ExcessFormFactory;
use Nette\Application\UI\Form;

class CreateExcessPresenter extends BasePresenter
{
    /**
     * @var ExcessFormFactory
     * @inject
     */
    public ExcessFormFactory $excessFormFactory;
    /**
     * @var ExcessEditFormFactory
     * @inject
     */
    public ExcessEditFormFactory $excessEditFormFactory;



    public function renderCreateExcess()
    {
        $getExcess = $this->tubeExcessModel->getExcess();
        $this->template->getExcess = $getExcess;
    }

    protected function createComponentExcessForm(): Form
    {
        $form = $this->excessFormFactory->create();
        $form->onSuccess['afterSave'] =
            function(){
            $this->redirect('this');
        };
        return $form;
    }
    protected function createComponentExcessEditForm(): Form
    {
        $form = $this->excessEditFormFactory->create();
        $form->onSuccess['afterSave'] =
            function(){
                $this->redirect('this');
            };
        return $form;
    }

    public function handleDelete(int $id)
    {
        $this->tubeExcessModel->deleteExcess($id);
        $this->flashMessage('Zakázka byla odstraněna.', 'success');
        $this->redirect('CreateExcess:createExcess');
    }

    public function handleEdit($material_id){
        $order_value = $this->tubeExcessModel->getExcessById($material_id);
        if (!$order_value) {
            $this->error('Materiál navíc nebyl nalezen');
        }
        $this['excessEditForm']->setDefaults($order_value);

        if ($this->isAjax()) {
            $this->payload->isModal = TRUE;
            $this->redrawControl("modal");

        }
    }
}