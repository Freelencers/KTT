<?php
class Commission extends CI_controller {
    
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model("Fanshine/M_commission");
    }

    public function getCommissionReportList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");

        $resultData = $this->M_commission->getCommissionReportList($currentPage, $limitPage, $search, "LIMIT");
        $resultData = $resultData->result();
 
        $allRows = $this->M_commission->getCommissionReportList($currentPage, $limitPage, $search, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);
 
        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $resultData;
 
        echo json_encode($json);
    }

    public function getCommissionList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");
        $filterColumn   = $this->input->post("filterColumn");
        $filterCondition= $this->input->post("filterCondition");
        $filterValue    = $this->input->post("filterValue");
        $cmsCmrId       = $this->input->post("cmsCmrId");

        $resultData = $this->M_commission->getCommissionList($currentPage, $limitPage, $search, "LIMIT", $filterColumn, $filterCondition, $filterValue, $cmsCmrId);
        $resultData = $resultData->result();
 
        $allRows = $this->M_commission->getCommissionList($currentPage, $limitPage, $search, "ALL", $filterColumn, $filterCondition, $filterValue, $cmsCmrId)->num_rows();
        $allPage = ceil($allRows / $limitPage);
 
        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $resultData;
 
        echo json_encode($json);
    }

    public function getCommissionAmount(){

        $result = $this->M_commission->getCommissionAmount()
                  ->row();
        
        $json["msg"] = "success";
        $json["status"] = 200;
        $json["response"]["amount"] = $result->cmsTotalCommission;

        echo json_encode($json);
    }

    public function generatePdfTransferList($cmrId=0){

        //lang load
		$languaue = $this->session->userdata("languaue");
        $this->lang->load('ktt', $languaue);

        // PDF load
        $this->load->library('Fpdf'); 
        $this->load->helper('download');
        $pdf = $this->fpdf;
        $pdf->fontpath = 'assets/font/'; 

        $pdf->AddPage();
		$pdf->AddFont('THSarabun','','THSarabun.php');
		$pdf->AddFont('THSarabun','B','THSarabun Bold Italic.php');
		$pdf->AddFont('THSarabun','I','THSarabun Italic.php');
		$pdf->AddFont('THSarabun','U','THSarabun Bold.php');
        $pdf->SetFont('THSarabun','',16);

        // transfer detail 
        $pdf->Text(130, 20, iconv( 'UTF-8','TIS-620', "ชื่อผู้โอน ............................................................. "));
        $pdf->Text(130, 30, iconv( 'UTF-8','TIS-620', "เบอร์โทร ............................................................ "));

        $tableData = $this->M_commission->getCommissionList(1, 100000, "", "ALL", "", "", "",$cmrId)
                     ->result();

        //echo json_encode($tableData);
        //die;

        /* ---- padding --- */
        $pdf->Cell( 190, 40,'', 0, 1,'R');

        $header = array(
            iconv( 'UTF-8','TIS-620', "รหัส"),
            iconv( 'UTF-8','TIS-620', "ชื่อบัญชี"),
            iconv( 'UTF-8','TIS-620', "ธนาคาร"),
            iconv( 'UTF-8','TIS-620', "สาขา"),
            iconv( 'UTF-8','TIS-620', "หมายเลขบัญชี"),
            iconv( 'UTF-8','TIS-620', "ยอดรวม")
        );
        $pdf->transferTable($header, $tableData);

        // amount
        $amount = 0;  
        for($i=0;$i<count($tableData);$i++){

            $amount += $tableData[$i]->cmsTotalCommission;
        }
        $pdf->Text(130, 40, iconv( 'UTF-8','TIS-620', "ยอดรวมทั้งสิ้น  " . number_format( $amount). "  บาท"));

        // Render
		$pdf->Output("assets/tempPDF/invoice.pdf","I");
		force_download($name, $data); 
    }

    public function generatePdfCommissionDetail($cmrId=0, $cusId=0){

        //lang load
		$languaue = $this->session->userdata("languaue");
        $this->lang->load('ktt', $languaue);

        // PDF load
        $this->load->library('Fpdf'); 
        $this->load->helper('download');
        $pdf = $this->fpdf;
        $pdf->fontpath = 'assets/font/'; 

        $pdf->AddPage();
		$pdf->AddFont('THSarabun','','THSarabun.php');
		$pdf->AddFont('THSarabun','B','THSarabun Bold Italic.php');
		$pdf->AddFont('THSarabun','I','THSarabun Italic.php');
		$pdf->AddFont('THSarabun','U','THSarabun Bold.php');
        $pdf->SetFont('THSarabun','', 16);



        //#######################
        // customer detail
        //#######################
        
        $this->load->model("Fanshine/M_customer");
        $invoiceDetail = $this->M_customer->getCustomerDetailById($cusId);

        // customer name 
        $pdf->Text(10, 30, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusFullName"]));
        // address detail
        $pdf->Text(10, 35, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusAddList"][0]->addDetail));
        // province name
        $pdf->Text(10, 40, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusAddList"][0]->prvName));
        // district name
        $pdf->Text(10, 45, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusAddList"][0]->disName));
        // postcode
        $pdf->Text(10, 50, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusAddList"][0]->addPostcode));
        // contact
        $pdf->Text(10, 55, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusContactList"][0]->conValue));
        // contact
        $pdf->Text(10, 60, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusContactList"][1]->conValue));
        
        //#######################
        // header 
        //#######################
        $pdf->SetFont('THSarabun','', 30);
        $pdf->Text(10, 15, iconv( 'UTF-8','TIS-620', "เอกสารรายละเอียดคอมมิสชัน"));
        $pdf->Text(140, 15, iconv( 'UTF-8','TIS-620', $invoiceDetail["cusCode"]));
        $pdf->Line(10,20,200,20);
        $pdf->SetFont('THSarabun','', 16);

        /* ---- padding --- */
        $pdf->Cell( 190, 60,'', 0, 1,'R');

        $header = array(
            iconv( 'UTF-8','TIS-620', "วันที่"),
            iconv( 'UTF-8','TIS-620', "รายละเอียด"),
            iconv( 'UTF-8','TIS-620', "ประเภท"),
            iconv( 'UTF-8','TIS-620', "คะแนน"),
            iconv( 'UTF-8','TIS-620', "คอมมิสชัน"),
        );

        // get data commission
		$amountOfNumber["commission"] = 0;
		$amountOfNumber["privatePoint"] = 0;
        $amountOfNumber["publicPoint"] = 0;
        
        $tableData = $this->M_commission->getCommissionHistoryList(1, 100000, "", "ALL", "", "", "",$cmrId, $cusId)
                      ->result();

        // ################################
        // Summary Detail of this report
        // ################################

        // Find start and end date
        $date = "";
        if($cmrId == 0){

            $date = date("Y")."-".date("m")."-".date("d");
        }else{

            $date = $this->db->select("cmrDate")
            ->from("commissionReport")
            ->where("cmrId", $cmrId)
            ->get()
            ->row();
            $date = $date->cmrDate;
        }
        $lastDayOfMonth = date('t',strtotime($date));
        $date = explode("-", $date);

        $settingValue = $this->M_general->getSettingValue();

        // calculate sum
        foreach($tableData as $row)
		{
			//type
			if($row->cmsTotalPrivatePoint){

				$type = "องค์กร";
				$point = $row->cmsTotalPublicPoint;
			}else{
				
				$type = "ส่วนตัว";
				$point = $row->cmsTotalPrivatePoint;
			}

			$amountOfNumber["commission"] 	+= $row->cmsTotalCommission;
			$amountOfNumber["privatePoint"]	+= $row->cmsTotalPrivatePoint;
			$amountOfNumber["publicPoint"] 	+= $row->cmsTotalPublicPoint;
        }
        
        // print date
        $pdf->Text(120, 30, iconv( 'UTF-8','TIS-620', "พิมพ์เมื่อ : ".date("d")."/".date("m")."/".(date("Y") + 543)));
        // customer name 
        $pdf->Text(120, 35, iconv( 'UTF-8','TIS-620', "ตั้งแต่วันที่ : ".$date[2]."/".$date[1]."/".($date[0] + 543)));
        // address detail
        $pdf->Text(120, 40, iconv( 'UTF-8','TIS-620', "สิ้นสุดวันที่ : ".$lastDayOfMonth."/".$date[1]."/".($date[0] + 543)));
        // province name
        $pdf->Text(120, 45, iconv( 'UTF-8','TIS-620', "คะแนนขั้นต่ำ : ". $settingValue[0]["standardPoint"]));
        // district name
        $pdf->Text(120, 50, iconv( 'UTF-8','TIS-620', "คะแนนส่วนตัวรวม : " . number_format( $amountOfNumber["privatePoint"])));
        // postcode
        $pdf->Text(120, 55, iconv( 'UTF-8','TIS-620', "คะแนนองค์กรรวม : " . number_format( $amountOfNumber["publicPoint"])));
        // contact
        $pdf->Text(120, 60, iconv( 'UTF-8','TIS-620', "คอมมิสชันรวม : " . number_format( $amountOfNumber["commission"])));

        // draw table
        $pdf->commissionPublicPointDetail($header, $tableData, $amountOfNumber);


        // Render
		$pdf->Output("assets/tempPDF/invoice.pdf","I");
		force_download($name, $data); 
    }

    public function commissionProcessReportOfMonth(){

        $this->load->library('email');
        $this->email->from('gatatong@fanshine.com', 'Gatatong');

        $lastCommissionReportId = $this->M_commission->generateCommissionReport();
        if($lastCommissionReportId != 0){

            $customerList = $this->M_commission->getCustomerIdOfReport($lastCommissionReportId);

            // email content
            $subject = "รายละเอียดคอมมิสชัน แฟรนไชน์ปาท่องโก๋กระทะทองประจำเดือน";
            $this->email->subject($subject);

            // send email
            for($i=0;$i<count($customerList);$i++){

                $sendTo = $customerList[$i]->conValue;
                $this->email->to($sendTo);
                $this->email->message('Testing the email class.');
                $this->generatePdfCommissionDetail($lastCommissionReportId, $customerList[$i]->cusId); 
                $this->email->attach('commissionReport.pdf', 'attachment', 'assets/tempPDF/invoice.pdf');
                $this->email->send();
            }
        }
        echo "PROCESS COMPLETE";

    }
}

?>