<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commission extends CI_Controller {

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
		// generate Report
		$this->load->model("Fanshine/M_commission");
		//$this->M_commission->generateCommissionReport();

		$session = $this->session->userdata();
		
		$profile["fullName"] = $session["accFirstname"] . " " . $session["accLastname"];
		$this->load->view("header", $profile);

		$dataList["menuList"] = $this->M_menu->getAccessModule();
		$this->load->view("sideBar", $dataList);
		// Languae Setting
		$word["pageTitle"] 			= $this->lang->line("moduleFanshineCommission");
		$word["commissionTime"] = $this->lang->line("fanshineCommissionCommissionTime");
		$word["commissionAmount"] = $this->lang->line("fanshineCommissionCommissionAmount");
		$word["filterTitle"] = $this->lang->line("fanshineCommissionFilterTitle");
		$word["searchTitle"] = $this->lang->line("fanshineCommissionSearchTitle");
		$word["cycleReport"] = $this->lang->line("fanshineCommissionReport");
		
		$word["cycleDate"] = $this->lang->line("fanshineCommissionCycleDate");
		$word["code"] = $this->lang->line("fanshineCommissionCode");
		$word["name"] = $this->lang->line("fanshineCommissionName");
		$word["bank"] = $this->lang->line("fanshineCommissionBank");
		$word["bankAccount"] = $this->lang->line("fanshineCommissionBankAccount");
		$word["privatePoint"] = $this->lang->line("fanshineCommissionPrivatePoint");
		$word["companyPoint"] = $this->lang->line("fanshineCommissionCompanyPoint");
		$word["amount"] = $this->lang->line("fanshineCommissionAmount");
		$word["commission"] = $this->lang->line("fanshineCommissionCommission");

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		// JS file
		$file["js"] = ["assets/application/fanshine/commission.js"];
		$this->load->view("Fanshine/Commission", $word);
		$this->load->view("footer", $file);
	}
}
