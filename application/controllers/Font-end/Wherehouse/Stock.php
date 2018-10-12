<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

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
		$word["pageTitle"] 				= $this->lang->line("moduleWherehouseStock");
		$word["refilsTitle"] 			= $this->lang->line("wherehouseStockRefils");
		$word["filterTitle"] 			= $this->lang->line("wherehouseStockFilter");
		$word["outOfStock"] 			= $this->lang->line("wherehouseStockOutOfStock");
		$word["outOfActualStock"]		= $this->lang->line("wherehouseStockOutOfActualStock");
		$word["refilsOfStock"] 			= $this->lang->line("wherehouseStockRefilsOfStock");
		$word["refilsOfActialStock"]	= $this->lang->line("wherehouseStockRefilsOfActualStock");
		$word["tabStock"] 				= $this->lang->line("wherehouseStockTabStock");
		$word["tabHistory"] 			= $this->lang->line("wherehouseStockTabHistory");
		$word["stockIn"] 				= $this->lang->line("wherehouseStockIn");
		$word["stockOut"] 				= $this->lang->line("wherehouseStockOut");
		$word["stockAction"] 			= $this->lang->line("wherehouseStockAction");
		
		$word["no"] 					= $this->lang->line("wherehouseStockNo");
		$word["sku"] 					= $this->lang->line("wherehouseStockSKU");
		$word["productName"] 			= $this->lang->line("wherehouseStockProductName");
		$word["type"] 					= $this->lang->line("wherehouseStockType");
		$word["location"] 				= $this->lang->line("wherehouseStockLocation");
		$word["stock"] 					= $this->lang->line("wherehouseStockStock");
		$word["actualStock"] 			= $this->lang->line("wherehouseStockActualStock");
		$word["actionTime"] 			= $this->lang->line("wherehouseStockActionTime");
		$word["amount"] 				= $this->lang->line("wherehouseStockAmount");
		$word["cost"] 					= $this->lang->line("wherehouseStockCost");
		$word["total"] 					= $this->lang->line("wherehouseStockTotal");
		$word["status"] 				= $this->lang->line("wherehouseStockStatus");
		$word["expire"] 				= $this->lang->line("wherehouseStockExpire");
		$word["modalTitle"] 			= $this->lang->line("wherehouseStockModalTitle");

		$word["save"] 					= $this->lang->line("generalSave");
		$word["close"] 					= $this->lang->line("generalClose");
		$word["action"] 				= $this->lang->line("generalAction");
		$word["no"] 					= $this->lang->line("generalNo");

		$this->load->view("Wherehouse/Stock", $word);
		$this->load->view("footer");
	}
}
