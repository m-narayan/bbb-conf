<?php
    class CommonFunctions extends Login { 
     
            
        //*************************************************//
        // To get the name of Storage location 
        //*************************************************//
        public function getBuyerStorageLocationsId($id) { 
            $param = array("_id" => $id);
            $statement = array('method_name' => 'getBuyerStorageLocations', 'param' => $param);
            $statement = json_encode($statement);
			//print_r($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
        
        //*************************************************//
        //        To get the name of Healthcare Entity
        //*************************************************//
        public function getHealthcareEntityName($id) {              
            $param = array("entity_id" => $id);
            $statement = array('method_name' => 'searchHealthcareEntity', 'param' => $param);
            $statement = json_encode($statement);
            socket_write($this->conn, $statement, strlen($statement));
            $server_reply =    $this->bufferToDisplay();
            $reply_json = json_decode($server_reply);
            return $reply_json;
        }
        
        //*****************************************************************//
        // To display the name of product passing product code as parameter.
        //*****************************************************************//
        
        
        
    }
?>