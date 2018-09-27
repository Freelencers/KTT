<?php 
class M_Account extends CI_Model {
    public function createNewAccount($accFirstname, $accLastname, $accUsername, $accPassword){
       
        $dataList = array (
            'accFirstname' => $accFirstname,
            'accLastname' => $accLastname,
            'accUsername' => $accUsername,
            'accPassword' => hash("sha256", $accPassword),
            'accCreatedate' => date('Y-m-d H:i:s'),
            'accCreateBy' => "1"
        );
        
        $this->db->insert("account", $dataList);
    }

    public function deleteAccount($accId) {
        $dataList = array(
            'accDeletedate' => date('Y-m-d H:i:s'),
            'accDeleteBy'  => "1"
        );
       
        $this->db->set($dataList);
        $this->db->where('accId', $accId);
        $this->db->update('account');
    }

    public function updateAccount($accId, $accFirstname, $accLastname, $accUsername, $accPassword) {
       
        $dataList  = array(
            'accFirstname' => $accFirstname,
            'accLastname' => $accLastname,
            'accUsername' => $accUsername,
            'accPassword' => hash("sha256", $accPassword),
            'accCreatedate' => date('Y-m-d H:i:s'),
            'accUpdateBy' => "1"
        );

        $this->db->set($dataList);
        $this->db->where('accId', $accId);
        $this->db->update('account');
    }
    
    public function getAccountById($accId) {

        $this->db->select('accId, accFirstname, accLastname, accUsername, DATE_FORMAT(accCreatedate, "%d/%m/%y") as accCreatedate');
        $this->db->where('accId', $accId);
        $query = $this->db->get('account');

        return $query;
    }

    public function countRowAccount($limitPage) {
        $rows = $this->db->query('SELECT * FROM account');
        $rowcount = $rows->num_rows();
        $pages = round(($rowcount / $limitPage));
    
        return $pages;
    }

    public function getAllAccount($perPages = 1, $limitPage = 1) {
        $offset = ($perPages-1)*$limitPage;

        $this->db->select('accId, accFirstname, accLastname, accUsername, DATE_FORMAT(accCreatedate, "%d/%m/%y") as accCreatedate');
        $this->db->limit($limitPage, $offset);
        $query = $this->db->get('account');

        return $query;
    }
    
    
}
?>