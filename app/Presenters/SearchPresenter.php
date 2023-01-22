<?php


namespace App\Presenters;


class SearchPresenter extends BasePresenter
{
    public function renderSearch()
    {
        $position = "Search:search";
        $this->template->position = $position;
    }
    public function actionSearch(string $search_value, int $option)
    {
        if ($option == 1){
            $tube_production = $this->tubeProductionModel->searchOrderByMaterial($search_value)->fetchAll();
        }
        else{
            $tube_production = $this->tubeProductionModel->searchOrderByOrder($search_value);
        }
        $this->template->tube_production = $tube_production;
    }
}