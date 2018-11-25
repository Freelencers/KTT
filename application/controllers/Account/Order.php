<?php
class Order extends CI_controller {
    
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model("Account/M_order");
    }

    public function getProductList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");

        $resultData = $this->M_order->getProductList($currentPage,$limitPage,$search, "LIMIT");
        $resultData = $resultData->result();
 
        $allRows = $this->M_order->getProductList($currentPage,$limitPage,$search, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);
 
        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $resultData;
 
        echo json_encode($json);
    }


    public function getMyOrderList(){

        $ordId          = $this->input->post("ordId");
        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");

        if($ordId == ""){

            $ordId = $this->session->userdata("ordId");
        }

        $myOrder = $this->M_order->getMyOrderList($ordId, $currentPage,$limitPage,$search, "LIMIT")->result();

        $allRows = $this->M_order->getMyOrderList($ordId, $currentPage,$limitPage,$search, "ALL")->num_rows();
        $allPage = round($allRows / $limitPage);

        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $myOrder;

        echo json_encode($json);
    }

    public function addToCart(){

        $sodOrdId = $this->session->userdata("ordId");
        $sodPrdId = $this->input->post("sodPrdId");
        $action   = $this->input->post("action");
        $sodQty   = $this->input->post("sodQty");

        $result = $this->M_order->addToCart($sodOrdId, $sodPrdId, $sodQty, $action);

        if($result){

            $json["status"] = 200;
            $json["msg"] = "success";
        }else{
        
            $json["status"] = 200;
            $json["msg"] = "error";
        }

        echo json_encode($json);
    }

    public function getOrderList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");


        $myOrder = $this->M_order->getOrderList($currentPage,$limitPage,$search, "LIMIT")->result();

        $allRows = $this->M_order->getOrderList($currentPage,$limitPage,$search, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);

        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $myOrder;

        echo json_encode($json);
    }

    public function getInvoiceDetail(){

        $ordId = $this->session->userdata("ordId");
        $result = $this->M_order->getInvoiceDetail($ordId);

        echo json_encode($result);

    }

    public function deleteOrder(){

        $ordId = $this->input->post("ordId");
        $resultData = $this->M_order->deleteOrder($ordId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

    public function removeFromCart(){
        $sodId = $this->input->post("sodId");
        $resultData = $this->M_order->removeFromCart($sodId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

    public function updateOrderStatus(){

        $ordId = $this->input->post("ordId");
        $resultData = $this->M_order->updateOrderStatus($ordId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

    public function createOrder(){

        $this->M_order->createOrder();

        $json['status'] = 200;
        $json['msg'] = "Success";
        echo json_encode($json);
    }


    public function complete($subTotal, $tax, $shipping, $isRedirect=true){

        $orderDetail["ordSubTotal"] = $subTotal;
        $orderDetail["ordShipping"] = $shipping;
        $orderDetail["ordTax"]      = $tax;
        $orderDetail["ordTotal"]    = $subTotal + $shipping + $tax;
        $orderDetail["ordStatus"]   = "WAIT-PAY";
        $orderDetail["ordCusId"]    = $this->session->userdata("ordCusId");
        $this->M_order->complete($orderDetail);
        if($isRedirect){

            redirect(base_url() . "index.php/Font-end/Account/Order");
        }
    }

    public function generateInvoicePDF($ordId=0, $subTotal=0, $tax=0, $shipping=0){

		//lang load
		$languaue = $this->session->userdata("languaue");
        $this->lang->load('ktt', $languaue);

        // PDF load
        $this->load->library('Fpdf'); 
        $this->load->helper('download');
        $pdf = $this->fpdf;
        $pdf->fontpath = 'assets/font/'; 

        // check from invoice page
        if($subTotal > 0 || $tax > 0 || $shipping > 0){

            // Save data
            $this->complete($subTotal, $tax, $shipping, false);
        }

        // if not pass ord Id
        if($ordId == 0){

            $ordId = $this->session->userdata("ordId");
        }

        // load data
        $this->load->model("M_order");
        $invoiceDetail = $this->M_order->getInvoiceDetail($ordId);

        $pdf->AddPage();
		$pdf->AddFont('THSarabun','','THSarabun.php');
		$pdf->AddFont('THSarabun','B','THSarabun Bold Italic.php');
		$pdf->AddFont('THSarabun','I','THSarabun Italic.php');
		$pdf->AddFont('THSarabun','U','THSarabun Bold.php');
        $pdf->SetFont('THSarabun','',16);
        

        // Order detail box

        // order code
        $pdf->Text(130, 20, 
            iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderCode") . " : " .
            $invoiceDetail["OrderDetail"]->ordCode
        ));

        // customer code
        $pdf->Text(130, 25, iconv( 'UTF-8','TIS-620', 
            $this->lang->line("accountOrderCustomerCode") . " : " .
            $invoiceDetail["OrderDetail"]->cusCode
        ));

        // order date
        $pdf->Text(130, 30, iconv( 'UTF-8','TIS-620', 
            $this->lang->line("accountOrderDate") . " : " .
            $invoiceDetail["OrderDetail"]->ordCreatedate
        ));
   
        // Kratatong box
        $pdf->Text(10, 45, iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderFrom")));
        $pdf->Text(10, 50, iconv( 'UTF-8','TIS-620', 'Gatatong Fanshine'));
        $pdf->Text(10, 55, iconv( 'UTF-8','TIS-620', '123/456 xxxx xxxx xxx'));
        $pdf->Text(10, 60, iconv( 'UTF-8','TIS-620', 'ชลบุรี'));
        $pdf->Text(10, 65, iconv( 'UTF-8','TIS-620', 'แสนสุข'));
        $pdf->Text(10, 70, iconv( 'UTF-8','TIS-620', '20130'));
        $pdf->Text(10, 75, iconv( 'UTF-8','TIS-620', 'gatatong@gmail.com'));
        $pdf->Text(10, 80, iconv( 'UTF-8','TIS-620', '0888888888'));


        // Customer box
        $pdf->Text(120, 45, iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderTo")));

        // customer name 
        $pdf->Text(120, 50, iconv( 'UTF-8','TIS-620', $invoiceDetail["OrderDetail"]->cusFullName));
        // address detail
        $pdf->Text(120, 55, iconv( 'UTF-8','TIS-620', $invoiceDetail["addressDetail"]->addDetail));
        // province name
        $pdf->Text(120, 60, iconv( 'UTF-8','TIS-620', $invoiceDetail["addressDetail"]->prvName));
        // district name
        $pdf->Text(120, 65, iconv( 'UTF-8','TIS-620', $invoiceDetail["addressDetail"]->disName));
        // postcode
        $pdf->Text(120, 70, iconv( 'UTF-8','TIS-620', $invoiceDetail["addressDetail"]->addPostcode));
        // contact
        $pdf->Text(120, 75, iconv( 'UTF-8','TIS-620', $invoiceDetail["contactDetail"][0]->conValue));
        // contact
        $pdf->Text(120, 80, iconv( 'UTF-8','TIS-620', $invoiceDetail["contactDetail"][1]->conValue));

        // Order item list
        $pdf->Cell( 20, 80,'',0,1,'C');
        //Column headings
        $header = array(
            iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderQty")),
            iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderProduct")),
            iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderPrice")),
            iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderPoint"))
        );

        // prepare data to array
        $data = array();
        for($i=0;$i<count($invoiceDetail["subOrderDetail"]);$i++){

            $data[$i][0] = iconv( 'UTF-8','TIS-620', $invoiceDetail["subOrderDetail"][$i]->sodQty);
            $data[$i][1] = iconv( 'UTF-8','TIS-620', $invoiceDetail["subOrderDetail"][$i]->matName);
            $data[$i][2] = iconv( 'UTF-8','TIS-620', $invoiceDetail["subOrderDetail"][$i]->prdPoint);
            $data[$i][3] = iconv( 'UTF-8','TIS-620', $invoiceDetail["subOrderDetail"][$i]->prdPrice);
        }

        // create table
        $pdf->ImprovedTable($header,$data);
        $pdf->ln();

        // Account Detail
        /* ---- padding --- */
        $pdf->Cell( 190, 5,'', 0, 1,'R');

        // Left 1
        $pdf->Cell( 20, 5, iconv( 'UTF-8','TIS-620', 
            $this->lang->line("accountOrderCustomerAccountName") . " : " .
            "KRATATONG"
        ), 0, 0,'L');

        // Right 1
        $pdf->Cell( 120, 5, iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderSubTotal")), 0, 0,'R');
        $pdf->Cell( 40, 5, number_format($invoiceDetail["OrderDetail"]->ordSubTotal), 0, 1,'R');

        // Left 2
        $pdf->Cell( 20, 5, iconv( 'UTF-8','TIS-620', 
            $this->lang->line("accountOrderCustomerAccountNo")). " : " .
            "000-000000-0"
        , 0, 0,'L');

        // Right 2
        $pdf->Cell( 120, 5, iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderShipping")), 0, 0,'R');
        $pdf->Cell( 40, 5, number_format($invoiceDetail["OrderDetail"]->ordShipping), 0, 1,'R');
        
        // Left 3
        $pdf->Cell( 20, 5, iconv( 'UTF-8','TIS-620',
            $this->lang->line("accountOrderCustomerBank"). " : " .
            "TMB"
        ), 0, 0,'L');

        // Right 3
        $pdf->Cell( 120, 5, iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderTax")), 0, 0,'R');
        $pdf->Cell( 40, 5, number_format($invoiceDetail["OrderDetail"]->ordTax), 0, 1,'R');
        
        // Left 5
        $pdf->Cell( 20, 5, iconv( 'UTF-8','TIS-620',
            $this->lang->line("accountOrderCustomerType") . " : " .
            $this->lang->line("fanshineCustomerAccountSaving")
        ), 0, 0,'L');

        // Right 4
        $pdf->Cell( 120, 5, iconv( 'UTF-8','TIS-620', $this->lang->line("accountOrderGrandTotal")), 0, 0,'R');
        $pdf->Cell( 40, 5, number_format($invoiceDetail["OrderDetail"]->ordTotal), 0, 1,'R');


        // Render
		$pdf->Output("assets/tempPDF/invoice.pdf","I");
		force_download($name, $data); 
    }

}

?>