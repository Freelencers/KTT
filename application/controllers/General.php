<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

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
	public function getLangLine()
	{
		//lang load
		$languaue = $this->session->userdata("languaue");
		$this->lang->load('ktt', $languaue);
		
		$str = $this->input->post("str");
		$data["status"] = 200;
		$data["msg"] = "success";
		$data["response"] = $this->lang->line($str);
		
		echo json_encode($data);
	}

	public function getSettingValue(){

		$result = $this->M_general->getSettingValue();
		echo json_encode($result);
	}

	public function test(){

		$this->load->model("Fanshine/M_customer");
		$this->M_customer->getHeaderIdOfthisChain(9);
	}

	public function resetData($password){
		
		$this->M_general->resetData($password);
	}

	public function goToSignIn(){

		redirect("/Font-end/Auth/signIn");
	}
}
