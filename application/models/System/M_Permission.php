<?php 
class M_Permission extends CI_Model {

    public function changePermission($accId, $modId, $access){

        // Check this module have permission
        $havePermission = $this->db->select("perId")
                            ->from("permission")
                            ->where("perAccId", $accId)
                            ->where("perModId", $modId)
                            ->get();
        $havePermission = $havePermission->num_rows();

        //echo $havePermission." : ".$access."<BR>";
        if($havePermission){

            if($access == 0){
                $this->db->where("perAccId", $accId)
                    ->where("perModId", $modId)
                    ->delete("permission");
            }
        }else{

            if($access == 1){

                $newPermission["perAccId"] = $accId;
                $newPermission["perModId"] = $modId;
                $this->db->insert("permission", $newPermission);
            }
        }

        return true;
    }

    public function getModuleList($accId){

        // get module list
        $modList = $this->db->select("modId, modName, modSection ")
                    ->from("module")
                    ->order_by("modOrder", "ASC");
        $modList = $modList->get()->result();

        // get permission of user
        $permissionList = $this->db->select("perModId")
                    ->from("permission")
                    ->where("perAccId", $accId);
        $permissionList = $permissionList->get()->result();

        // convert permission user to array
        $modId = array();
        foreach($permissionList as $permission){

            array_push($modId, $permission->perModId);
        }
        //echo json_encode($modId);

        // Convert to new format
        $json = array();
        $modSection = "";
        $index = 0;
        $moduleListIndex = 0;
        $tempArray = array();

        $round = 0;
        foreach($modList as $mod){

            // inittial section
            if($modSection != $mod->modSection){

                // step to next section but fisrt time not increase index
                if($round > 0){
                
                    $index++;
                }

                // create new data set
                $modSection = $mod->modSection;
                $json["permissionList"][$index]["permissionSection"] = $mod->modSection;
                $json["permissionList"][$index]["moduleList"] = array();
            }

            // initial module name and permission in current section
            $languaue = $this->session->userdata("languaue");
            $this->lang->load('ktt', $languaue);
            
            $tempArray["modName"] = $this->lang->line("module" . ucwords($mod->modSection) . ucwords($mod->modName));
            $tempArray["modId"] = $mod->modId;
            if(array_search( $mod->modId, $modId) !== FALSE){

                $tempArray["modPermission"] = 1;
            }else{

                $tempArray["modPermission"] = 0;
            }

            array_push( $json["permissionList"][$index]["moduleList"], $tempArray);
            $round++;
        }

        return $json;
    }
}