<?php
class Expense extends CI_controller {
    
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model("Account/M_expense");
    }

    public function getExpenseList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");
        $startDate      = $this->input->post("startDate");
        $endDate        = $this->input->post("endDate");
        $type           = $this->input->post("type");

        $resultData = $this->M_expense->getExpenseList($currentPage, $limitPage, $search, $startDate, $endDate, $type, "LIMIT");
        $resultData = $resultData->result();
 
        $allRows = $this->M_expense->getExpenseList($currentPage, $limitPage, $search, $startDate, $endDate, $type, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);
 
        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $resultData;
 
        echo json_encode($json);
    }

    public function getExpenseListAndAmount(){

        $result = $this->M_expense->getExpenseListAndAmount();

        $json["status"]     = 200;
        $json["msg"]        = "success";
        $json["response"]   = $result;

        echo json_encode($json);
    }

    public function getExpenseDetail(){

        $epnId = $this->input->post("epnId");
        $result = $this->M_expense->getExpenseDetail($epnId);

        $json["status"]                 = 200;
        $json["msg"]                    = "success";
        $json["response"]["dataRow"]    = $result->row();

        echo json_encode($json);
    }

    public function deleteExpense(){

        $epnId = $this->input->post("epnId");
        $this->M_expense->deleteExpense($epnId);

        $json["status"]                 = 200;
        $json["msg"]                    = "success";

        echo json_encode($json);
    }

    public function createExpense(){

        $input = $this->input->post();
        $input["epnCusId"] = $this->session->userdata("accId");
        
        $this->M_expense->createExpense($input);

        $json["status"] = 200;
        $json["msg"]    = "success";

        echo json_encode($json);
    }

    public function updateExpense(){

        $input = $this->input->post();
        $epnId = $this->input->post("epnId");

        // remove epn id from update list;
        unset($input["epnId"]);

        $this->M_expense->updateExpense($input, $epnId);

        $json["status"] = 200;
        $json["msg"] = "success";

        echo json_encode($json);
    }

}

?>