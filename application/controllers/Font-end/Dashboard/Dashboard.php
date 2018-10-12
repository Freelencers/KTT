<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$word["pageTitle"] 			= $this->lang->line("moduleDashboardDashboard");
		$word["shippingCount"] 		= $this->lang->line("shippingCount");
		$word["payCount"] 			= $this->lang->line("payCount");
		$word["newFanshineCount"] 	= $this->lang->line("newFanshineCount");
		$word["stockRefilsCount"] 	= $this->lang->line("stockRefilsCount");
		$word["fanshineTree"] 		= $this->lang->line("fanshineTree");
		$word["orderToday"] 		= $this->lang->line("orderToday");
		$word["orderAmount"]		= $this->lang->line("orderAmount");
		$word["orderCount"]			= $this->lang->line("orderCount");

		$this->load->view("Dashboard/Dashboard", $word);
		$file["js"] = ["assets/application/dashboard/dashboard.js"];
		$this->load->view("footer", $file);
	}
}
