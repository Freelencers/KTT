<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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
		$word["pageTitle"] 			= $this->lang->line("moduleWherehouseLocation");
		$word["sku"] 				= $this->lang->line("wherehouseProductSKU");
		$word["productName"] 		= $this->lang->line("wherehouseProductName");
		$word["location"] 			= $this->lang->line("wherehouseProductLocaiton");
		$word["unit"] 				= $this->lang->line("wherehouseProductUnit");
		$word["min"] 				= $this->lang->line("wherehouseProductMin");
		$word["max"] 				= $this->lang->line("wherehouseProductMax");
		$word["type"] 				= $this->lang->line("wherehouseProductType");
		$word["modalTitle"] 		= $this->lang->line("wherehouseProductModalTitle");
		$word["createNewProduct"] 	= $this->lang->line("wherehouseProductCreateNewProduct");

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		$this->load->view("Wherehouse/Product", $word);
		$this->load->view("footer");
	}
}
