<?php

    class Login { 
        
        public $counter=0;
        public $conn;
		//echo $_SESSION['st'];
        // Defaut Constructor Creation
        public function Login(){ 
		
            $this->connection();
        }
        
		public function sclose() { 
		
		    socket_close($this->conn);
		}
        public function connection() { 
            
           $this->conn = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            
            if ($this->conn === false) {
                echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
                return;
            } else { 
              // $counter=$counter+1;
               //echo $counter;
             // echo "Cnnection Working fine \n";
            }
			//echo $this->conn = $_SESSION['st'];
			
			//$_SESSION['st'] = $this->conn;
			
 
            $result = socket_connect($this->conn, TCP_SERVER_IP, TCP_SERVER_PORT);

            if ($result === false) {
                echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
                return;
            } else {
                //echo "Socket Connection: OK.\n";
            } 
        }
        
        public function checkFieldEmpty($userName,$pass) { 
            if($userName == "" || $pass=="") { 
                return 1;  // fail
            }
            else {
                return 2; // success
            }
        }
        
        public function authenticateUser($userName,$pass) {
            $auth_array = array('username' => $userName, 'password' => $pass,'SEND_DATA_LENGTH' => true);
            $login_credentials = json_encode($auth_array);
            $server_reply = " ";
            socket_write($this->conn, $login_credentials, strlen($login_credentials));
            $server_reply =	$this->bufferToDisplay();
            $reply_json = json_decode( $server_reply );
            return $reply_json;
        }
        

        public function bufferToDisplay() {
            $response = '';
            $ret_size = '';
            $buf = '';
            $loop_counter = 1;

            while( $ret = socket_recv($this->conn,$buf,1024,0)){
                if($loop_counter == 1) {
                    $exp = explode('{',$buf);
                    $len = $exp[0] + strlen($exp[0]);
                } 
                
                $ret_size  = $ret_size + $ret;
                $response.=$buf;
                $loop_counter++;
                if($ret_size == $len) break;
            }

            $server_reply = substr($response ,  strlen($exp[0]));
            return $server_reply;
        }
    }
?>