<?php 
    class Location extends CI_controller {
        public function createNewLocation() {
            $locName = $this->input->post("locName");
            $locDetail = $this->input->post("locDetail");

            
           $this->load->model("Wherehouse/M_location");
           $result = $this->M_location->createNewLocation($locName, $locDetail);
        
           $json = $result;
           echo json_encode($json);
        }
 
        public function updateLocationDetail() {
            $locId = $this->input->post("locId");
            $locName = $this->input->post("locName");
            $locDetail = $this->input->post("locDetail");

            $this->load->model("Wherehouse/M_location");
            $result = $this->M_location->updateLocationDetail($locId, $locName, $locDetail);

            $json = $result;
            echo json_encode($json);
        }
        public function getLocationDetailById() {
            $locId = $this->input->post("locId");

            $this->load->model("Wherehouse/M_location");
            $queryData = $this->M_location->getLocationDetailById($locId);
            $queryData = $queryData->result();

            if(!$queryData) {
                $json['status'] = 204;
                $json['msg'] = "No Content";
                echo json_encode($json);
            } else {
                $dataRow = json_decode(json_encode((object) $queryData[0]), FALSE);
                $json['status'] = 200;
                $json['msg'] = "Success";
                $json['response']['dataRow'] = $dataRow;
                echo json_encode($json);
            }
            
        }
        public function deleteLocation() {
            $locId = $this->input->post("locId");

            $this->load->model("Wherehouse/M_location");
            $result = $this->M_location->deleteLocation($locId);

            if($result) {
                $json['status'] = 200;
                $json['msg'] = "Success";
                echo json_encode($json);
            } else {
                $json['status'] = 200;
                $json['msg'] = "Error";
                echo json_encode($json);
            }
        }
        public function getLocationList(){
            $currentPage = $this->input->post("currentPage");
            $limitPage = $this->input->post("limitPage");
            $search = $this->input->post("search");

            $this->load->model("Wherehouse/M_location");
            $allPageNumber = $this->M_location->countRowLocation($limitPage);

            $queryData = $this->M_location->getLocationList($currentPage, $limitPage, $search);
            $dataList = $queryData->result();

            $json['response']['pagination'] = genPagination($currentPage, $allPageNumber);
            $json['response']['dataList'] = $dataList;
            echo json_encode($json);
            // echo json_encode($pages);
        }
    }
?>