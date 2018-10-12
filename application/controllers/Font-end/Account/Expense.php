<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {

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
		$word["date"] 				= $this->lang->line("accountExpenseDate");
		$word["title"] 				= $this->lang->line("accountExpenseTitle");
		$word["detail"] 			= $this->lang->line("accountExpenseDetail");
		$word["type"] 				= $this->lang->line("accountExpenseType");
		$word["amount"] 			= $this->lang->line("accountExpenseAmount");
		$word["income"] 			= $this->lang->line("accountExpenseIncome");
		$word["outcome"] 			= $this->lang->line("accountExpenseOutcome");
		$word["filterTitle"] 		= $this->lang->line("accountExpenseFilterTitle");
		$word["expenseToday"] 		= $this->lang->line("accountExpenseExpenseToday");
		$word["createNewExpense"] 	= $this->lang->line("accountExpenseCreateNewExpense");

		$word["save"] 				= $this->lang->line("generalSave");
		$word["close"] 				= $this->lang->line("generalClose");
		$word["action"] 			= $this->lang->line("generalAction");
		$word["no"] 				= $this->lang->line("generalNo");

		$this->load->view("Account/Expense", $word);
		$this->load->view("footer");
	}
}
