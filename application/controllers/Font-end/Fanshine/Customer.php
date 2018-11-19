<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

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
		$word["pageTitle"] 			= $this->lang->line("moduleFanshineCustomer");
		$word["code"] 				= $this->lang->line("fanshineCustomerCode");
		$word["fullName"] 			= $this->lang->line("fanshineCustomerFullName");
		$word["status"] 			= $this->lang->line("fanshineCustomerStatus");
		$word["level"] 				= $this->lang->line("fanshineCustomerLevel");
		$word["createdate"] 		= $this->lang->line("fanshineCustomerCreadtedate");
		$word["createNewFanshine"] 	= $this->lang->line("fanshineCustomerCreateNewFanshine");
		
		$word["modalTitle"] 		= $this->lang->line("fanshineCustomerModalTitle");
		$word["fanshineName"] 		= $this->lang->line("fanshineCustomerFanshineName");
		$word["birthday"] 			= $this->lang->line("fanshineCustomerBirthday");
		$word["country"] 			= $this->lang->line("fanshineCustomerCountry");
		$word["passportId"] 		= $this->lang->line("fanshineCustomerPassportId");
		$word["personalId"] 		= $this->lang->line("fanshineCustomerPersonalId");
		$word["address"] 			= $this->lang->line("fanshineCustomerAddress");
		$word["province"] 			= $this->lang->line("fanshineCustomerProvince");
		$word["district"] 			= $this->lang->line("fanshineCustomerDistrict");
		$word["postcode"] 			= $this->lang->line("fanshineCustomerPostcode");
		$word["phoneNumber"] 		= $this->lang->line("fanshineCustomerPhoneNumber");
		$word["email"] 				= $this->lang->line("fanshineCustomerEmail");
		$word["deliveryAddress"] 	= $this->lang->line("fanshineCustomerDeliveryAddress");
		$word["bankAccount"] 		= $this->lang->line("fanshineCustomerBankAccount");
		$word["branch"] 			= $this->lang->line("fanshineCustomerBranch");
		$word["accountName"] 		= $this->lang->line("fanshineCustomerAccountName");
		$word["refer"] 				= $this->lang->line("fanshineCustomerRefer");
		$word["maritalStatus"] 		= $this->lang->line("fanshineCustomerMaritalStatus");
		$word["child"] 				= $this->lang->line("fanshineCustomerChild");
		$word["descendantName"] 	= $this->lang->line("fanshineCustomerDescendantName");
		$word["bank"] 				= $this->lang->line("fanshineCustomerBank");
		$word["accountType"] 		= $this->lang->line("fanshineCustomerAccountType");
		$word["savingAccount"] 		= $this->lang->line("fanshineCustomerAccountSaving");
		$word["currentAccount"] 	= $this->lang->line("fanshineCustomerAccountCurrent");

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		// JS file
		$file["js"] = [
			"assets/plugins/input-mask/jquery.inputmask.js",
			"assets/plugins/input-mask/jquery.inputmask.date.extensions.js",
			"assets/plugins/input-mask/jquery.inputmask.extensions.js",
			"assets/application/fanshine/customer.js"];
		$this->load->view("Fanshine/Customer", $word);
		$this->load->view("footer", $file);
	}
}
