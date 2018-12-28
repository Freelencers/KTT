<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Growth extends CI_Controller {

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
		$word["pageTitle"] 			= $this->lang->line("moduleReportGrowth");
		$word["code"]               = $this->lang->line("reportGrowthCode");
		$word["fanshineName"]       = $this->lang->line("reportGrowthFanshineName");
		$word["avg"]                = $this->lang->line("reportGrowthAVG");
		

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		// JS file
		$file["js"] = [
			"assets/bower_components/datatables.net/js/jquery.dataTables.min.js",
			"assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js",
			"assets/application/Report/growth.js"
		];
		$this->load->view("Report/Growth", $word);
		$this->load->view("footer", $file);
	}
}
