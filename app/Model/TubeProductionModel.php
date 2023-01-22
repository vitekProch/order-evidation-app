<?php

namespace App\Model;

use App\Repository\TubeProductionRepository;
use Nette\Database\ResultSet;
use Nette\Database\Table\Selection;

class TubeProductionModel
{
    /**
     * @var TubeProductionRepository
     * @inject
     */
    public TubeProductionRepository $tubeProductionRepository;

    public function __construct(TubeProductionRepository $tubeProductionRepository)
    {
        $this->tubeProductionRepository = $tubeProductionRepository;
    }
    public function getTubeProduction($limit, $offset): array
    {
        $orders = $this->tubeProductionRepository->getTubeProduction();
        $current_material = 0;
        $new_values = [];
        $same_material = [];
        $displayed_order = [];
        $index_new = 0;
        $index_material = 0;

        foreach ($orders as $order)
        {

            if ($order->material_id != $current_material){
                $new_values[$index_new]['order_id'] = $order->order_id;
                $new_values[$index_new]['id'] = $order->id;
                $new_values[$index_new]['material_id'] = $order->material_id;
                $new_values[$index_new]['name'] = $order->name;
                $new_values[$index_new]['employee_id'] = $order->employee_id;
                $new_values[$index_new]['diameter'] = $order->diameter;
                $new_values[$index_new]['made_quantity'] = $order->made_quantity;
                $new_values[$index_new]['create_date'] = $order->create_date;
                $new_values[$index_new]['shift_name'] = $order->shift_name;
                $new_values[$index_new]['excess_quantity'] = $order->excess_quantity;
                $index_new += 1;

            }
            else{

                $same_material[$index_new][$index_material]['order_id'] = $order->order_id;
                $same_material[$index_new][$index_material]['id'] = $order->id;
                $same_material[$index_new][$index_material]['material_id'] = $order->material_id;
                $same_material[$index_new][$index_material]['name'] = $order->name;
                $same_material[$index_new][$index_material]['employee_id'] = $order->employee_id;
                $same_material[$index_new][$index_material]['diameter'] = $order->diameter;
                $same_material[$index_new][$index_material]['made_quantity'] = $order->made_quantity;
                $same_material[$index_new][$index_material]['create_date'] = $order->create_date;
                $same_material[$index_new][$index_material]['shift_name'] = $order->shift_name;
                $same_material[$index_new][$index_material]['excess_quantity'] = $order->excess_quantity;
                $index_material += 1;
            }
            $current_material = $order->material_id;
        }

        //   PAGINATION   //

        foreach (range(($offset), $offset + $limit - 1) as $i){
            $displayed_order[$i]['order_id'] = $new_values[$i]['order_id'];
            $displayed_order[$i]['id'] = $new_values[$i]['id'];
            $displayed_order[$i]['material_id'] = $new_values[$i]['material_id'];
            $displayed_order[$i]['name'] = $new_values[$i]['name'];
            $displayed_order[$i]['employee_id'] = $new_values[$i]['employee_id'];
            $displayed_order[$i]['diameter'] = $new_values[$i]['diameter'];
            $displayed_order[$i]['made_quantity'] = $new_values[$i]['made_quantity'];
            $displayed_order[$i]['create_date'] = $new_values[$i]['create_date'];
            $displayed_order[$i]['shift_name'] = $new_values[$i]['shift_name'];
            $displayed_order[$i]['excess_quantity'] = $new_values[$i]['excess_quantity'];
        }

        return array($displayed_order, $same_material);
    }

    public function getCountAllProduction($limit = ""): int
    {
        $counter = 0;
        $current_material_id = "";
        $material = $this->tubeProductionRepository->getCountAllProduction();
        foreach ($material as $material_id){
            if ($limit == $counter){
                break;
            }
            if ($material_id->material_id == $current_material_id){
                $counter -= 1;
            }
            $current_material_id = $material_id->material_id;
            $counter += 1;
        }
        return $counter;
    }

    public function insertNewData($order_id, $material_id, $employee_id, $tube_diameter, $made_quantity, $shift_id, $excess_quantity)
    {
        $this->tubeProductionRepository->insertNewData($order_id, $material_id, $employee_id, $tube_diameter, $made_quantity, $shift_id, $excess_quantity);
    }

    public function searchOrderByOrder($order_id): ResultSet
    {
        return $this->tubeProductionRepository->searchOrderByOrder($order_id);
    }
    public function searchOrderByMaterial($material_id): ResultSet
    {
        return $this->tubeProductionRepository->searchOrderByMaterial($material_id);
    }

    public function getLastDiameter(): string
    {
        return $this->tubeProductionRepository->getLastDiameter();
    }

    public function getOrderById(): Selection
    {
        return $this->tubeProductionRepository->getOrderById();
    }

    public function updateNewData($id, $material_id, $tube_diameter, $made_quantity, $shift_id, $order_id, $excess_quantity)
    {
        $this->tubeProductionRepository->updateNewData($id, $material_id, $tube_diameter, $made_quantity, $shift_id, $order_id, $excess_quantity);
    }
    public function deleteRecord($id)
    {
        $this->tubeProductionRepository->deleteRecord($id);
    }

}