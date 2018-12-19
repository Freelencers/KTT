<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_general extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	 public function getSettingValue(){
		 
		// get setting from schedule
		$settingList = $this->db->select("ssgId, ssgDateStart, ssgDateEnd, sscName, sscValue")
		->from("settingScheduleGroup")
		->join("settingSchedule", "ssgId = sscSsgId")
		->where("NOW() BETWEEN ssgDateStart AND ssgDateEnd")
		->get();


		if($settingList->num_rows() == false){

			// Not have schedule get by default
			$settingList = $this->db->select("1 AS ssgId, 0 AS ssgDateStart, 0 AS ssgDateEnd, sedName AS sscName, sedValue AS sscValue")
			->from("settingDefault")
			->get();
		}

		return convertSettingFormat($settingList->result());
	 }

	 public function resetData($password){

		if($password == "pakornt"){

			echo "table address empty <BR>";
			$this->db->empty_table("address");

			echo "table bankAccount empty <BR>";
			$this->db->empty_table("bankAccount");

			echo "table commission empty <BR>";
			$this->db->empty_table("commission");

			echo "table commissionReport empty <BR>";
			$this->db->empty_table("commissionReport");

			echo "table subOrder empty <BR>";
			$this->db->empty_table("subOrder");

			echo "table stockHistory empty <BR>";
			$this->db->empty_table("stockHistory");

			echo "table stock empty <BR>";
			$this->db->empty_table("stock");

			echo "table settingScheduleGroup empty <BR>";
			$this->db->empty_table("settingScheduleGroup");

			echo "table settingSchedule empty <BR>";
			$this->db->empty_table("settingSchedule");

			echo "table productPrie empty <BR>";
			$this->db->empty_table("productPrice");

			echo "table product empty <BR>";
			$this->db->empty_table("product");

			echo "table order empty <BR>";
			$this->db->empty_table("order");

			echo "table material empty <BR>";
			$this->db->empty_table("material");

			echo "table location empty <BR>";
			$this->db->empty_table("location");

			echo "table levelUp empty <BR>";
			$this->db->empty_table("levelUp");

			echo "table expense empty <BR>";
			$this->db->empty_table("expense");

			echo "table customer empty <BR>";
			$this->db->empty_table("customer");

			echo "table contact empty <BR>";
			$this->db->empty_table("contact");

			echo "table permission empty <BR>";
			$this->db->where("perAccId != 1")
			->delete("permission");

			echo "table account empty <BR>";
			$this->db->where("accId != 1")
			->delete("account");
		}
	 }
}
