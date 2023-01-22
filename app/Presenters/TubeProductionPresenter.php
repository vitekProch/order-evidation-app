<?php

namespace App\Presenters;
use Nette;

class TubeProductionPresenter extends BasePresenter
{
    public function renderProduction(int $page = 1)
    {
        $position = $this->getAction() . "?" . "page=" . $page;
        $productionCount = $this->tubeProductionModel->getCountAllProduction();
        $paginator = new Nette\Utils\Paginator;
        $paginator->setItemCount($productionCount); // celkový počet položek, je-li znám
        $paginator->setItemsPerPage(7); // počet položek na stránce
        $paginator->setPage($page); // číslo aktuální stránky
        $tube_production = $this->tubeProductionModel->getTubeProduction($paginator->getLength(), $paginator->getOffset());

        $this->template->position = $position;
        $this->template->tube_production = $tube_production;
        $this->template->paginator = $paginator;
    }


    public function renderEdit(int $id): void
    {
        $tube_production = $this->tubeProductionModel->getTubeProduction(1,0);
        $material_id = $this->tubeProductionModel->getOrderById()->get($id);
        $employee_name = $this->employeeModel->getEmployeeName($material_id->employee_id);
        $employee_id = $material_id->toArray()["employee_id"];

        $this->template->employee_id = $employee_id;
        $this->template->tube_production = $tube_production;
        $this->template->material_id = $material_id;
        $this->template->employee_name = $employee_name;
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
