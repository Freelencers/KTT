 <?php
class M_order extends CI_Model {

    public function getProductList($currentPage,$limitPage,$search,$matType="",$orlimit){

        $result = $this->db->select("matCode AS prdMatCode, matName AS prdMatName, prdId, prdPoint, prdFullPrice, prdDiscount, stoVirtualStock, untName")
        ->from("product")
        ->join("material",'matId = prdMatId', "inner")
        ->join("unit", "untId = matUntId", "inner")
        ->join("stock", "stoMatId = prdMatId AND stoLast = 1")
        ->where("matDeleteBy IS NULL");

        if($matType){

            $this->db->where("matType",$matType);
        }
    
        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->group_end();
        }

        if($orlimit == "dataList"){

            $offset = ($currentPage-1)*$limitPage;
            $this->db->order_by("prdId", "DESC")
            ->limit($limitPage, $offset);    
        }
        return $this->db->get();
    }

    public function getMyOrderList($ordId,$currentPage,$limitPage,$search,$mode){

        $this->db->select("matCode AS prdMatCode, matName AS prdMatName, prdPoint, (prdFullPrice - prdDiscount) AS prdSellPrice, untName, sodQty")
        ->from("order")        ->join("subOrder"   , "ordId = sodOrdId", "inner")
        ->join("product"    , "sodPrdId = prdId", "inner")
        ->join("material"   , "prdMatId = matId", "inner")
        ->join("unit"       , "matUntId = untId", "inner")
        ->where("ordId", $ordId);

        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->group_end();
        }

        if($mode == "LIMIT"){

            $offset = ($currentPage-1)*$limitPage;
            $this->db->order_by("ordId", "DESC")
            ->limit($limitPage, $offset);    
        }

        return $this->db->get();
    }

    public function addToCart($sodOrdId, $sodPrdId, $sodQty){

        $subOrderList["sodOrdId"]   = $sodOrdId;
        $subOrderList["sodQty"]     = $sodQty;
        $subOrderList["sodPrdId"]   = $sodPrdId;

        $this->db->insert("subOrder", $subOrderList);

        return $this->db->affected_rows();
    }
   
    public function getOrderList($currentPage,$limitPage,$search, $mode){

        $result = $this->db->select("ordId, ordCode, cusFullName, ordStatus, ordTotal, DATE(ordCreatedate) AS ordCreatedate")
        ->from("order")
        ->join("customer", "cusId = ordCusId", "inner");
        //->join("subOrder", "sodOrdId = ordId", "inner")
        //->join("product", "prdId = sodPrdId", "inner");
    
        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->group_end();
        }

        if($mode == "LIMIT"){

            $offset = ($currentPage-1)*$limitPage;
            $this->db->order_by("ordId", "DESC")
            ->limit($limitPage, $offset);    
        }
        return $this->db->get();
    }

    public function getInvoiceDetail($ordId){

        $orederDetail =  $this->db->select("ordId, ordSubTotal, ordShipping, ordTax, ordTotal, ordCode, ordCreatedate, ordCusId")
                            ->from("order")
                            ->where("ordId", $ordId)
                            ->get()
                            ->row();

        $addressDetail = $this->db->select("addDetail, addPostcode, prvName, disName, addType")
                            ->from("address")
                            ->join("province"   , "prvId = addProvince", "inner")
                            ->join("district"   , "disId = addDistrict", "inner")
                            ->where("addCusId", $orederDetail->ordCusId)
                            ->get()
                            ->result();

        $contactDetail = $this->db->select("conName, conValue")
                            ->from("contact")
                            ->where("conCusId" , $orederDetail->ordCusId)
                            ->get()
                            ->result();

        $subOrderDetail = $this->db->select("sodQty, matName, prdPoint, (prdFullPrice - prdDiscount) AS prdPrice")
                            ->from("subOrder")
                            ->join("product"    , "sodPrdId = prdId", "inner")
                            ->join("material"   , "prdMatId = matId", "inner")
                            ->where("sodOrdId", $ordId)
                            ->get()
                            ->result();

        $json["OrderDetail"] = $orederDetail;
        $json["addressDetail"] = $addressDetail;
        $json["contactDetail"] = $contactDetail;
        $json["subOrderDetail"] = $subOrderDetail;

        return $json;
    }
}
?>