<?php

namespace App\Presenters;

class ExcessPresenter extends HomepagePresenter
{
    public function beforeRender()
    {
        parent::beforeRender();
        $this->searchExcess();
        $this->updateExcess();
        $this->deleteExcess();

    }

    public function searchExcess()
    {
        if(isset($_POST['input'])){
            $input =  $_POST['input'];
            $data = $this->tubeExcessModel->findExcess($input);
            $this->template->data = $data;
        }
    }
    public function updateExcess()
    {
        if(isset($_POST['quantityUpdate'])){
            $quantitySend = $_POST['quantityUpdate'];
            $orderId = $_POST['orderId'];
            $this->tubeExcessModel->newExcessQuantity($orderId, $quantitySend);
            $data = $this->tubeExcessModel->findExcess($orderId);
            $this->template->data = $data;

            $this->flashMessage('Proběhlo upravení existujicího záznamu', 'success');
        }
    }
    public function deleteExcess()
    {
        if(isset($_POST['deleteId'])){
            $excessId = $_POST['deleteId'];
            $this->tubeExcessModel->deleteExcess($excessId);
        }
    }
}