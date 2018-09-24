<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {

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
    public function getAccessModule($accId=1){

		$accId = $this->session->userdata("accId");
		
		// get menu can access
        $this->db->select("modHumanName, modIcon, modDestination, modSection, modName")
        ->from("permission")
		->join("module", "perModId = modId", "inner")
		->where("perAccId", $accId);
		$modList["permission"] = $this->db->get()->result();

		// get mene section can access
        $this->db->select("modSection")
        ->from("permission")
		->join("module", "perModId = modId", "inner")
		->where("perAccId", $accId)
		->group_by("modSection")
		->order_by("modOrder", "ASC");
		$modList["section"] = $this->db->get()->result();


		return $modList;
    }
}
