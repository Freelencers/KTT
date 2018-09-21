<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {

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
		$this->load->model("M_access");
	}

	public function signIn(){

		// parameter from POST
		$accUsername = $this->input->post("accUsername");
		$accPassword = $this->input->post("accPassword");
		$signInResult = $this->M_access->signIn($accUsername, $accPassword);
		
		// account is correct
		if($signInResult->num_rows()){
			
			// session declare
			$profile = $signInResult->result();
			$sess = array(
				"accId"		   => $profile[0]->accId,
				"accUsername"  => $profile[0]->accUsername,
				"accFirstname" => $profile[0]->accFirstname,
				"accLastname"  => $profile[0]->accLastname,
				"languaue"	   => "english"
			);
			$this->session->set_userdata($sess);

			// redirect
			redirect("/Font-end/Welcome");
		}else{
		
			redirect("/Font-end/Auth/signIn/0");
		}
	}

	public function signOut(){

		$this->session->sess_destroy();
		redirect("/Font-end/Auth/signIn");
	}

	public function languaue($switchTo){
		
		switch($switchTo){

			case "TH" : $this->session->set_userdata("languaue", "thai");
						break;

			case "EN" : $this->session->set_userdata("languaue", "english");
						break;
		}
		header("location:".base_url("index.php/Font-end/Welcome"));
	}
}
