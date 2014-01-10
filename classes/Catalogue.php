<?php
    class Catalogue extends Login { 

        /*
        Method to get list of Product catalogue
        */
        public function get_product_catalog() {
            $param = array("" => "");
            $statement = array('method_name' => 'get_product_catalog', 'param' => $param);
            $statement = json_encode($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		public function get_product_catalogById($id) {
            $param = array("p_code" => $id);
            $statement = array('method_name' => 'get_product_catalog', 'param' => $param);
            $statement = json_encode($statement);
			//print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }

        /*
        Method to get Create catalogue 
        */
        public function create_product_catalog($methodName,$p_code,$p_name,$p_class_code,$p_cs_doc,$p_sup_id,$p_ndc,$p_patgrp_anal_doc,$urlArray,$imageListArray,$p_tm_file,$p_tech_spec,$p_ct_doc,$p_um_file,$p_bar_code,$p_unit_wt,$icdListArray,$p_eval_doc,$p_kb,$p_outcome_doc,$p_sup_item) { 
            $p_image_list = "[]";
            $p_urls = "[]";
            $p_icd_list = "[]";
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"p_code": "'.$p_code.'","p_name": "'.$p_name.'","p_class_code": "'.$p_class_code.'","p_cs_doc": "'.$p_cs_doc.'","p_ndc": "'.$p_ndc.'","p_urls": '.$p_urls.',"p_image_list": '.$p_image_list.',"p_tm_file": "'.$p_tm_file.'","p_tech_spec": "'.$p_tech_spec.'","p_ct_doc": "'.$p_ct_doc.'","p_um_file": "'.$p_um_file. '","p_bar_code": "'.$p_bar_code.'","p_icd_list": '.$p_icd_list.',"p_eval_doc": "'.$p_eval_doc.'","p_kb": "'.$p_kb.'","p_outcome_doc": "'.$p_outcome_doc.'","p_sup_item": "'.$p_sup_item.'"}}';
			//print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }


        /*
        Method to get all Catalogue with it's ID'
        */
        public function get_product_cat_by_id($id) { 
            $param = array("_id" => $id);
            $statement = array('method_name' => 'get_product_catalog', 'param' => $param);
            $statement = json_encode($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }

        /*
        Method to Update Product Catalogue
        */
        public function update_product_catalog($p_code,$p_name,$p_class_code,$p_cs_doc,$p_sup_id,$p_ndc,$p_patgrp_anal_doc,$urlArray,$imageListArray,$p_tm_file,$p_tech_spec,$p_ct_doc,$p_um_file,$p_bar_code,$p_unit_wt,$icdListArray,$p_eval_doc,$p_kb,$p_outcome_doc,$p_sup_item,$vid) { 
            $p_image_list = "[]";
            $p_urls = "[]";
            $p_icd_list = "[]";
            $methodName = 'update_product_catalog';
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"p_code": "'.$p_code.'","p_name": "'.$p_name.'","p_class_code": "'.$p_class_code.'","p_cs_doc": "'.$p_cs_doc.'","p_sup_id": "'.$p_sup_id .'","p_ndc": "'.$p_ndc.'","p_urls": '.$p_urls.',"p_image_list": '.$p_image_list.',"p_tm_file": "'.$p_tm_file.'","p_tech_spec": "'.$p_tech_spec.'","p_ct_doc": "'.$p_ct_doc.'","p_um_file": "'.$p_um_file. '","p_bar_code": "'.$p_bar_code.'","p_icd_list": '.$p_icd_list.',"p_eval_doc": "'.$p_eval_doc.'","p_kb": "'.$p_kb.'","p_outcome_doc": "'.$p_outcome_doc.'","p_sup_item": "'.$p_sup_item.'","_id": "'.$vid.'"}}';
			//print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }

        /*
        Method to Delete catalogue
        */
        public function delete_product_catalog($id) {
            $param = array("_id" => $id);
            $statement = array('method_name' => 'delete_product_catalog', 'param' => $param);
            $statement = json_encode($statement);
			print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		
		public function CreateGFSSupplierDocFileID($doc_name,$dt_id) {
            $param = array("doc_name" => $doc_name,"dt_id" => $dt_id);
            $statement = array('method_name' => 'CreateGFSSupplierDocFileID', 'param' => $param);
            $statement = json_encode($statement);
			//print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		public function update_clinical_catalog($p_ct_doc,$vid) { 
            
            $methodName = 'update_product_catalog';
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"p_ct_doc": "'.$p_ct_doc.'","_id": "'.$vid.'"}}';
			print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		public function update_images_catalog($imgName,$vid) { 
            $p_image_list = '["'.$imgName.'"]';
            
            $methodName = 'update_product_catalog';
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"p_image_list": '.$p_image_list.',"_id": "'.$vid.'"}}';
			print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		public function update_tech_catalog($p_tech_spec,$vid) { 
            
            $methodName = 'update_product_catalog';
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"p_tech_spec": "'.$p_tech_spec.'","_id": "'.$vid.'"}}';
			print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		public function update_manual_catalog($p_um_file,$vid) { 
            
            $methodName = 'update_product_catalog';
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"p_um_file": "'.$p_um_file.'","_id": "'.$vid.'"}}';
			print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		public function searchMSupCatalog($conditionType,$cValue) { 
            
            $methodName = 'searchMasterSupCatalog';
            $statement = '{"method_name": "'.$methodName.'",'.'"param": {"'.$conditionType.'": "'.$cValue.'"}}';
			//print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
		
		

    }
?>