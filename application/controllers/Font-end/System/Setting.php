<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

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

	public function __construct(){

		parent::__construct();

		// Check Authentication
		if(!$this->session->userdata("accUsername")){

			redirect("/Font-end/Auth/signIn/0");
		}

		//lang load
		$languaue = $this->session->userdata("languaue");
		$this->lang->load('ktt', $languaue);

		//echo $this->lang->line("signInFail");
	}	

	public function index()
	{
		$session = $this->session->userdata();
		
		$profile["fullName"] = $session["accFirstname"] . " " . $session["accLastname"];
		$this->load->view("header", $profile);

		$dataList["menuList"] = $this->M_menu->getAccessModule();
		$this->load->view("sideBar", $dataList);

		// Languae Setting
		$word["pageTitle"] 			= $this->lang->line("moduleSystemSetting");
		$word["defaultSetting"] 	= $this->lang->line("systemSettingDefaultSetting");
		$word["moneyToPoint"]		= $this->lang->line("systemSettingMoneyToPoint");
		$word["pointToMoneyLevelS"]	= $this->lang->line("systemSettingPointToMoneyLevelS");
		$word["pointToMoneyLevelL"]	= $this->lang->line("systemSettingPointToMoneyLevelL");
		$word["tax"]				= $this->lang->line("systemSettingTax");
		$word["memberFee"]			= $this->lang->line("systemSettingMemberFee");
		$word["specialCondition"]	= $this->lang->line("systemSettingSpecialCondition");
		$word["pounderWeight"]		= $this->lang->line("systemSettingPounderWeight");
		$word["commission"]			= $this->lang->line("systemSettingCommission");
		$word["refer"]				= $this->lang->line("systemSettingRefer");
		$word["standardPoint"]		= $this->lang->line("systemSettingStandardPoint");
		$word["schedule"]			= $this->lang->line("systemSettingSchedule");
		$word["history"]			= $this->lang->line("systemSettingHistory");
		$word["date"]				= $this->lang->line("generalDate");
		$word["dateStart"]			= $this->lang->line("generalDateStart");
		$word["dateEnd"]			= $this->lang->line("generalDateEnd");
		$word["createSchedule"]		= $this->lang->line("systemSettingCreateSchedule");
		$word["modalTitle"]			= $this->lang->line("systemSettingModalTitle");

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		// JS file
		$file["js"] = [
			"assets/bower_components/moment/min/moment.min.js",
			"assets/bower_components/bootstrap-daterangepicker/daterangepicker.js",
			"assets/application/system/setting.js"]
		;
		$this->load->view("System/Setting", $word);
		$this->load->view("footer", $file);
	}
}
