<?php
class Commission extends CI_controller {
    
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model("Fanshine/M_commission");

        $this->load->library('email');

        // $config['protocol'] = 'sendmail';
        // $config['mailpath'] = '/usr/sbin/sendmail';
        // $config['charset'] = 'iso-8859-1';
        // $config['wordwrap'] = TRUE;
        $config['protocol'] = 'ssmtp';
        $config['smtp_host'] = 'ssl://ssmtp.gmail.com';
        $this->email->initialize($config);

        // $this->email->from('your@example.com', 'Your Name');
        // $this->email->to('pakorn_traipan@icloud.com');
        // $this->email->subject('Email Test');
        // $this->email->message('Testing the email class.');
        // $this->email->send();
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

    public function generatePdfCommissionDetail($cmrId=0, $cusId=0, $renderType="I"){

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
        $index = 0;
        foreach($tableData as $row)
		{
            
			$amountOfNumber["commission"] 	+= $row->cmsTotalCommission;
			$amountOfNumber["privatePoint"]	+= $row->cmsTotalPrivatePoint;
            $amountOfNumber["publicPoint"] 	+= $row->cmsTotalPublicPoint;
            $index++;
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
        $pdf->Output("assets/tempPDF/invoice.pdf",$renderType);
        
        if($renderType == "I"){

            force_download($name, $data); 
        }
    }

    public function commissionProcessReportOfMonth(){

        $lastCommissionReportId = $this->M_commission->generateCommissionReport();
        if($lastCommissionReportId != 0){

            $customerList = $this->M_commission->getCustomerIdOfReport($lastCommissionReportId);

            // email content
            $subject = "รายละเอียดคอมมิสชัน แฟรนไชน์ปาท่องโก๋กระทะทองประจำเดือน " . date("m") . "/" . date("Y");
            

            // send email
            for($i=0;$i<count($customerList);$i++){

                $this->email->clear();
                $this->email->set_mailtype("html");
                $sendTo = $customerList[$i]->conValue;
                //$sendTo = 'pakorn_traipan@icloud.com';
                $this->email->from('no-reply@patonggogtt.com', 'Gatatong');
                $this->email->to($sendTo);
                $this->email->subject($subject);
                $body = $this->generateHtmlToSendEmail( $lastCommissionReportId, $customerList[$i]->cmsCusId);
                $this->email->message($body);

                if(!$this->email->send()){

                    echo "SEND TO " . $sendTo . " IS FALSE<BR>";
                }else{
                    echo "SEND TO " . $sendTo . " IS SUCCESS<BR>";
                }
            }
        }
        echo "PROCESS COMPLETE";
    }

    public function generateHtmlToSendEmail($cmrId, $cusId){

        $body = "";
        //lang load
		$languaue = $this->session->userdata("languaue");
        $this->lang->load('ktt', $languaue);

        //#######################
        // customer detail
        //#######################
        
        $this->load->model("Fanshine/M_customer");
        $invoiceDetail = $this->M_customer->getCustomerDetailById($cusId);

        $body .= "<b>ข้อมูลสมาชิก</b><BR>";
        // customer name 
        $body .= "" . $invoiceDetail["cusFullName"] . "<BR>";
        // address detail
        $body .= "" . $invoiceDetail["cusAddList"][0]->addDetail . "<BR>";
        // province name
        $body .= "" . $invoiceDetail["cusAddList"][0]->prvName . "<BR>";
        // district name
        $body .= "" . $invoiceDetail["cusAddList"][0]->disName . "<BR>";
        // postcode
        $body .= "" . $invoiceDetail["cusAddList"][0]->addPostcode . "<BR>";
        // contact
        $body .= "" . $invoiceDetail["cusContactList"][0]->conValue . "<BR>";
        // contact
        $body .= "" . $invoiceDetail["cusContactList"][1]->conValue . "<BR>";
        $body .= "<BR>";

        $tableData = $this->M_commission->getCommissionHistoryList(1, 100000, "", "ALL", "", "", "", $cmrId, $cusId)
                      ->result();

        // ################################
        // Summary Detail of this report
        // ################################

        // Find start and end date
        $date = "";
        $amountOfNumber = array();
        $amountOfNumber["commission"] 	= 0;
        $amountOfNumber["privatePoint"] = 0;
        $amountOfNumber["publicPoint"] 	= 0;

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


        $body .= "<b>ตารางรายละเอียดคะแนน</b><BR>";
        $body .= "<table border='1'>";

        // Header
        $header = array(
            "วันที่",
            "รายละเอียด",
            "ประเภท",
            "คะแนน",
            "คอมมิสชัน",
        );
        $body .= "<thead>";
        foreach($header as $row){

            $body .= "<th>".$row."</th>";
        }
        $body .= "</thead>";

        // Body
        $body .= "<tbody>";
        foreach($tableData as $row)
		{
            $body .= "<tr>";
			$body .= "<td>" . $row->cmsCreatedate . "</td>";
			$body .= "<td>" . $row->cmsDetail . "</td>";

			//type
			if($row->cmsTotalPrivatePoint <= 0){

				$type = "องค์กร";
				$point = $row->cmsTotalPublicPoint;
			}else{
				
				$type = "ส่วนตัว";
				$point = $row->cmsTotalPrivatePoint;
			}

			$body .= "<td>" . $type . "</td>";
			$body .= "<td>" . number_format( $point) . "</td>";
            $body .= "<td>" . number_format( $row->cmsTotalCommission) . "</td>";
            
            $body .= "</tr>";
			

			$amountOfNumber["commission"] 	+= $row->cmsTotalCommission;
			$amountOfNumber["privatePoint"] += $row->cmsTotalPrivatePoint;
			$amountOfNumber["publicPoint"] 	+= $row->cmsTotalPublicPoint;
        }
        $body .= "</tbody>";
        $body .= "</table>";

        $body .= "<BR><BR>";

        // calculate sum
        $body .= "<b>ข้อมูลสรุปรวม</b><BR>";
        $body .= "พิมพ์เมื่อ : ".date("d")."/".date("m")."/".(date("Y") + 543) . "<BR>";
        $body .= "ตั้งแต่วันที่ : ".$date[2]."/".$date[1]."/".($date[0] + 543) . "<BR>";
        $body .= "สิ้นสุดวันที่ : ".$lastDayOfMonth."/".$date[1]."/".($date[0] + 543) . "<BR>";
        $body .= "คะแนนขั้นต่ำ : ". $settingValue[0]["standardPoint"] . "<BR>";
        $body .= "คะแนนส่วนตัวรวม : " . number_format( $amountOfNumber["privatePoint"]) . "<BR>";
        $body .= "คะแนนองค์กรรวม : " . number_format( $amountOfNumber["publicPoint"]) . "<BR>";
        $body .= "คอมมิสชันรวม : " . number_format( $amountOfNumber["commission"]) . "<BR>"; 

        return $body;
    }
}

?>