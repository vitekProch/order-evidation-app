<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\OrderFormFactory;
use Nette\Application\UI\Form;

class HomepagePresenter extends BasePresenter
{
    /**
     * @var OrderFormFactory
     * @inject
     */
    public OrderFormFactory $orderFormFactory;

    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Pro vytvoření nové zakázky je nutné se přihlásit!', 'error');
            $this->redirect('Sign:in');
        }
    }

    public function renderDefault($data)
    {
        $position = "Homepage:";
        $tube_diameters = $this->tubeDiameterModel->getDiameters();
        $tube_production = $this->tubeProductionModel->getTubeProduction(4, 0);
        $this['orderForm']->setValues(array(
            'diameters' => $this->tubeProductionModel->getLastDiameter()
        ), true);

        $this->template->position = $position;
        $this->template->tube_production = $tube_production;
        $this->template->tube_diameters = $tube_diameters;
        if (!isset($this->template->data)) {
            $this->template->data = $data;
        }
    }
    public function createComponentOrderForm(): Form
    {
        $form = $this->orderFormFactory->create();
        $form->onSuccess['afterSave'] =
            function(){
                $this->redirect('this');
            };
        return $form;
    }

    public function handleShow(array $modal_data)
    {
        $this->template->modal_data = $modal_data;
        if ($this->isAjax()) {
            $this->payload->isModal = TRUE;
            $this->redrawControl("modal");
        }
    }
}
