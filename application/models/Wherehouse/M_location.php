<?php 
    class M_location extends CI_Model {
        public function createNewLocation($locName , $locDetail) {
            $dataList = array (
                'locName' => $locName,
                'locDetail' => $locDetail,
                'locCreatedate' => date('Y-m-d H:i:s'),
                'locCreateBy' => "1"
            );
            $checkError = 0;
            $response = array();
                if(!$locName) {
                    $checkError += 1;
                    $response["locName"] = "Please enter location name";
                }
                if(!$locDetail) {
                    $checkError += 1;
                    $response["locDetail"] = "Please enter location detail";
                }
            if($checkError == 0) {
                $dbRet =  $this->db->insert("location", $dataList);
                if($dbRet) {
                    $locData = array (
                        "status" => "200",
                        "msg" => "Success",
                        "response" => "",
                    );
                    return $locData;
                }
            } else {
                $locData = array (
                    "status" => "200",
                    "msg" => "Error",
                    "response" => array("error" => $response),
                );
                return $locData;
            }
       }

       public function updateLocationDetail($locId, $locName, $locDetail) {
            $dataList = array (
                'locName' => $locName,
                'locDetail' => $locDetail,
                'locUpdatedate' => date('Y-m-d H:i:s'),
                'locUpdateBy' => "1"
            );
            $checkError = 0;
            $response = array();
                if(!$locName) {
                    $checkError += 1;
                    $response["locName"] = "Please enter location name";
                }
                if(!$locDetail) {
                    $checkError += 1;
                    $response["locDetail"] = "Please enter location detail";
                }
            if($checkError == 0) {

                    $this->db->set($dataList);
                    $this->db->where('locId', $locId);
                    $updateData = $this->db->update('location');
                if($updateData){
                    $locData = array (
                        "status" => "200",
                        "msg" => "Success",
                        "response" => "",
                    );
                    return $locData;
                }      
            } else {
                $locData = array (
                    "status" => "200",
                    "msg" => "Error",
                    "response" => array("error" => $response),
                );
                return $locData;
            }
       }
       public function getLocationDetailById($locId) {
            $this->db->select('locId, locName, locDetail');
            $this->db->where('locId', $locId);
            $query = $this->db->get('location');
            return $query;
       }

       public function deleteLocation($locId) {
         $dataList = array(
            'locDeletedate' => date('Y-m-d H:i:s'),
            'locDeleteBy'  => "1"
         );
       
         $this->db->set($dataList);
         $this->db->where('locId', $locId);
         $updateDate = $this->db->update('location');
         
         return $updateDate;
       }

       public function countRowLocation($limitPage) {
            $rows = $this->db->query('SELECT * FROM location');
            $rowcount = $rows->num_rows();
            $pages = round(($rowcount / $limitPage));
    
            return $pages;
       }
       public function getLocationList($currentPage, $limitPage) {
            
            $offset = ($currentPage-1)*$limitPage;
            $this->db->select('locId, locName, locDetail');
            $this->db->limit($limitPage, $offset);
            $query = $this->db->get('location');
    
            return $query;
       }
    }
?>