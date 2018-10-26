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
}
