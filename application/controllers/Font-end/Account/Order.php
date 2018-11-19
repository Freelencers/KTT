<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

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
		$word["pageTitle"] 			= $this->lang->line("moduleAccountOrder");
		$word["date"] 				= $this->lang->line("accountOrderDate");
		$word["code"] 				= $this->lang->line("accountOrderCode");
		$word["fanshineName"] 		= $this->lang->line("accountOrderFanshineName");
		$word["amount"] 			= $this->lang->line("accountOrderAmount");
		$word["status"] 			= $this->lang->line("accountOrderStatus");
		$word["createNewOrder"] 	= $this->lang->line("accountOrderCreateNewOrder");

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		// JS file
		$file["js"] = ["assets/application/Account/order.js"];
		$this->load->view("Account/Order", $word);
		$this->load->view("footer", $file);
	}

	public function createOrder(){

		$session = $this->session->userdata();
		
		$profile["fullName"] = $session["accFirstname"] . " " . $session["accLastname"];
		$this->load->view("header", $profile);

		$dataList["menuList"] = $this->M_menu->getAccessModule();
		$this->load->view("sideBar", $dataList);

		// Languae Setting
		$word["pageTitle"] 		= $this->lang->line("moduleAccountOrder");
		$word["orderCreate"]	= $this->lang->line("accountOrderOrderCreate");
		$word["customer"] 		= $this->lang->line("accountOrderCustomer");
		$word["goToShop"] 		= $this->lang->line("accountOrderGoToShop");
		$word["invoid"] 		= $this->lang->line("accountOrderInvoid");
		$word["point"] 			= $this->lang->line("accountOrderPoint");
		$word["amount"] 		= $this->lang->line("accountOrderAmount");
		$word["checkOut"] 		= $this->lang->line("accountOrderCheckOut");
		$word["product"] 		= $this->lang->line("accountOrderProduct");
		$word["myOrder"] 		= $this->lang->line("accountOrderMyOrder");
		$word["code"] 			= $this->lang->line("accountOrderCode");
		$word["price"] 			= $this->lang->line("accountOrderPrice");
		$word["stock"] 			= $this->lang->line("accountOrderStock");

		$word["save"] 			= $this->lang->line("generalSave");
		$word["close"] 			= $this->lang->line("generalClose");
		$word["action"] 		= $this->lang->line("generalAction");
		$word["no"] 			= $this->lang->line("generalNo");

		// JS file
		$file["js"] = ["assets/application/Account/createOrder.js"];
		$this->load->view("Account/CreateOrder", $word);
		$this->load->view("footer", $file);
	}
}
