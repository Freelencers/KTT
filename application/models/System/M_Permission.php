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
}