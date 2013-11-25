<?php
    class DBAccess{

        public function checkMaxMeeting($user_id){
            $msg="";
            $period=-1;
            $max_conference=-1;
            $sql="select * from user_settings where user_id=".$user_id;
            $result=mysql_query($sql);
            while($row=mysql_fetch_array($result)){
                $period=$row['period'];
                $max_conference=$row['max_conference'];
            }
            if($period==0){
                $date=date("Ymd");
                $date = date("Ymd",strtotime(date("Ymd", strtotime($date)) . "-6 day"));
                $sql="select count(*) as meeting_count from meetings where owner_id=".$user_id." and meeting_date >=".$date." and meeting_date<=".date(Ymd);
                $result=mysql_query($sql);
                $row=mysql_fetch_array($result);
                if($max_conference != -1 && $row['meeting_count'] >= $max_conference  ){
                    $msg="You can create only a maximum of $max_conference conference in a week";
                }
            }else if($period==1){
                $date=date("Ymd");
                $date = date("Ymd",strtotime(date("Ymd", strtotime($date)) . "-1 month"));
                $sql="select count(*) as meeting_count from meetings where owner_id=".$user_id." and meeting_date >=".$date." and meeting_date<=".date(Ymd);
                $result=mysql_query($sql);
                $row=mysql_fetch_array($result);
                if($max_conference != -1 && $row['meeting_count'] >= $max_conference  ){
                    $msg="You can create only a maximum of $max_conference conference in a month";
                }
            }
            echo $msg;
        }

        public function getAllSettings(){
            $sql="select a.full_name,b.* from users a,user_settings b where a.id=b.user_id order by full_name";
            return(mysql_query($sql));
        }

        public function addUserSettings($user_id,$period,$max_conference) {
            $sql="select * from user_settings where user_id=".$user_id;
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            if($count==1){
                $sql="update user_settings set period=".$period.", max_conference=".$max_conference." where user_id=".$user_id;
                mysql_query($sql);
            }else{
                $sql="insert into user_settings (user_id,period,max_conference) values(".$user_id.",".$period.",".$max_conference.")";
                mysql_query($sql);
            }
        }

        public function getAllUsersExceptAdmin(){
            $sql="select * from users where login <>'admin' order by full_name";
            return(mysql_query($sql));
        }

        public function checkUser($login,$pass){
            $sql="select * from users where login='".$login."' and password='".$pass."'";
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            return $count;
        }

        public function getUser($login,$pass){
            $sql="select * from users where login='".$login."' and password='".$pass."'";
            $result=mysql_query($sql);
            $row=mysql_fetch_array($result);
            return $row;
        }

        public function createOrUpdateUser($login,$password,$email,$full_name){
            $sql="select * from users where login='".$login."'";
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            $row=mysql_fetch_array($result);
            $pos=strpos($full_name,'.');
            $full_name=substr($full_name,$pos+2,strlen($full_name));
            $full_name=str_replace(',', '', $full_name);
            if($count==1){
                $sql="update users set email='".$email."',password='".$password."',full_name='".$full_name."' where login='".$login."'";
            }else{
                $sql="insert into users (login,password,email,full_name) values ('".$login."','".$password."','".$email->user_email."','".$full_name."')";
            }
            mysql_query($sql);
        }

        public function addServer($name,$url,$salt,$status) {
            $sql="insert into servers (name,url,salt,status) values('".$name."','".$url."','".$salt."',".$status.")";
            mysql_query($sql);
        }

        public function updateServer($id,$name,$url,$salt,$status) {
            $sql="update servers set name='".$name."',url='".$url."',salt='".$salt."',status=".$status." where id=".$id;
            mysql_query($sql);
        }

        public function deleteServer($id) {
            $sql="delete from  servers where id=".$id;
            mysql_query($sql);
        }

        public function getServer($id){
            $sql="select * from servers where id=".$id;
            $result=mysql_query($sql);
            $row=mysql_fetch_array($result);
            return($row);
        }

        public function getAllServers(){
            $sql="select * from servers";
            return(mysql_query($sql));
        }

        public function getRandomServer(){
            $sql="select * from servers where status=1 order by rand() limit 1";
            $result=mysql_query($sql);
            $row=mysql_fetch_array($result);
            return($row);
        }

        public function checkServerInUse($id){
            $flag=false;
            $sql="select * from meetings where server_id=".$id;
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            if($count==1) $flag=true;
            return $flag;
        }

        public function fromDBDate($date){
            $y=substr($date,0,4);
            $m=substr($date,4,2);
            $d=substr($date,6,2);
            return $m."/".$d."/".$y;
        }

        public function addMeeting($meetingid,$server_id,$attendeePw,$moderatorPw,$owner_id,$name,$welcome_msg,$meeting_date,$duration,$speaker,$topic) {
            $temp=$meeting_date;
            $temp=explode(" ",$temp);
            $meeting_date=$temp[0];
            $meeting_time=$temp[1];
            $date=explode("/",$meeting_date);
            $meeting_date=$date[2].$date[0].$date[1];
            $sql="insert into meetings (meetingid,server_id,owner_id,name,welcome_msg,record,meeting_date,meeting_time,duration,moderator_password,attendee_password,speaker,topic,status) ";
            $sql=$sql." values('".$meetingid."',".$server_id.",".$owner_id.",'".$name."','".$welcome_msg."','true','".$meeting_date."','".$meeting_time."',".$duration.",'".$moderatorPw."','".$attendeePw."','".$speaker."','".$topic."','active')";
            mysql_query($sql);

            $sql = "select max(id) as max from meetings";
            $result=mysql_query($sql);
            $row = mysql_fetch_array($result);
            return($row['max']);
        }

        public function addInvitations($meeting_id,$users){
            foreach($users as $user_id){
                $sql="insert into invitations (meeting_id,user_id) values(".$meeting_id.",".$user_id.")";
                mysql_query($sql);
            }
        }

        public function getMeeting($id){
            $sql="select * from meetings where id=".$id;
            $result=mysql_query($sql);
            $row=mysql_fetch_array($result);
            return($row);
        }

        public function getAllMeetings($owner_id){
            $sql="select * from meetings where owner_id=".$owner_id;
            return(mysql_query($sql));
        }

        public function getJoinRequests($owner_id){
            $sql="select a.*,b.full_name from meetings a,users b where a.status='active' and a.owner_id=b.id and owner_id<>".$owner_id;
            $sql=$sql." and a.id not in (select meeting_id from invitations where user_id=".$owner_id.")";
            return(mysql_query($sql));
        }

        public function getAllUsers($owner_id){
            $sql="select * from users where id<>".$owner_id;
            return(mysql_query($sql));
        }

        public function enroll($meeting_id,$user_id){
            $sql="insert into invitations (meeting_id,user_id) values(".$meeting_id.",".$user_id.")";
            mysql_query($sql);
        }

        public function deenroll($meeting_id,$user_id){
            $sql="delete from invitations where meeting_id=".$meeting_id." and user_id=".$user_id;
            mysql_query($sql);
        }

        public function enrolledConferences($owner_id){
            $sql="select a.*,b.full_name from meetings a,users b,invitations c where a.id=c.meeting_id and b.id=c.user_id and owner_id<>".$owner_id;
            return(mysql_query($sql));
        }


        public function checkEnrollment($meeting_id,$user_id){
            $flag=false;
            $sql="select * from invitations where meeting_id=".$meeting_id." and user_id=".$user_id;
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            if($count>=1) $flag=true;
            return($flag);
        }

    }
?>