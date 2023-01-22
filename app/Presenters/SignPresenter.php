<?php

namespace App\Presenters;
use App\Forms\SignInFormFactory;
use App\Forms\SignUpFormFactory;
use Nette\Application\UI\Form;



class SignPresenter extends BasePresenter
{
    /**
     * @var SignUpFormFactory
     * @inject
     */
    public SignUpFormFactory $signUpFormFactory;

    /**
     * @var SignInFormFactory
     * @inject
     */
    public SignInFormFactory $signInFormFactory;

    protected function afterRender()
    {
        parent::afterRender();
        $this['signInForm']->setValues(array(
            'shift' => $this->signModel->automaticShiftSelect()
        ), true);
    }


    protected function createComponentSignUpForm(): Form
    {
        return $this->signUpFormFactory->create();
    }


    protected function createComponentSignInForm(): Form
    {
        return $this->signInFormFactory->create();
    }

    public function actionOut(): void
    {
        $this->user->logout(true);
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.','success');
        $this->redirect('Sign:in');
    }
    public function test(){
            // Load the database configuration file
            include_once 'dbConfig.php';

    // Filter the excel data
            function filterData(&$str){
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

    // Excel file name for download
            $fileName = "members-data_" . date('Y-m-d') . ".xls";

    // Column names
            $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'GENDER', 'COUNTRY', 'CREATED', 'STATUS');

    // Display column names as first row
            $excelData = implode("\t", array_values($fields)) . "\n";

    // Fetch records from database
            $query = $db->query("SELECT * FROM members ORDER BY id ASC");
            if($query->num_rows > 0){
                // Output each row of the data
                while($row = $query->fetch_assoc()){
                    $status = ($row['status'] == 1)?'Active':'Inactive';
                    $lineData = array($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['gender'], $row['country'], $row['created'], $status);
                    array_walk($lineData, 'filterData');
                    $excelData .= implode("\t", array_values($lineData)) . "\n";
                }
            }else{
                $excelData .= 'No records found...'. "\n";
            }

    // Headers for download
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$fileName\"");

    // Render excel data
            echo $excelData;

            exit;
    }

}