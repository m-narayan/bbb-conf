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

        public function getSetting($id){
            $sql="select a.full_name,b.* from users a,user_settings b where a.id=b.user_id and b.id=".$id;
            $result=mysql_query($sql);
            $row=mysql_fetch_array($result);
            return $row;
        }

        public function updateSetting($id,$period,$max_conference) {
            $sql="update user_settings set period=".$period.", max_conference=".$max_conference." where id=".$id;
            mysql_query($sql);
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

        public function checkUser($login,$pass,$userType){
            $sql="select * from users where login='".$login."' and password='".$pass."' and user_type='".$userType."'";
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

        public function createOrUpdateUser($login,$password,$email,$full_name,$user_type){
            $sql="select * from users where login='".$login."'";
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            $row=mysql_fetch_array($result);
            $pos=strpos($full_name,'.');
            $full_name=substr($full_name,$pos+2,strlen($full_name));
            $full_name=str_replace(',', '', $full_name);
            $user_type=strtolower($user_type);
            if($count==1){
                $sql="update users set email='".$email."',password='".$password."',full_name='".$full_name."',user_type='".$user_type."' where login='".$login."'";
            }else{
                $sql="insert into users (login,password,email,full_name,user_type) values ('".$login."','".$password."','".$email."','".$full_name."','".$user_type."')";
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

        public function deleteSettings($id) {
            $sql="delete from  user_settings where id=".$id;
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
            if($count>=1) $flag=true;
            return $flag;
        }

        public function fromDBDate($date){
            $y=substr($date,0,4);
            $m=substr($date,4,2);
            $d=substr($date,6,2);
            return $m."/".$d."/".$y;
        }

        public function setMeetingId($id,$meetingid){
            $sql="update meetings set meetingid='".$meetingid."' where id=".$id;
            mysql_query($sql) or die(mysql_error());
        }

        public function setStarted($id){
            $sql="update meetings set started='true' where id=".$id;
            mysql_query($sql) or die(mysql_error());
        }

        public function addMeeting($server_id,$attendeePw,$moderatorPw,$owner_id,$name,$welcome_msg,$meeting_date,$duration,$speaker,$topic,$slide) {
            $temp=$meeting_date;
            $temp=explode(" ",$temp);
            $meeting_date=$temp[0];
            $meeting_time=$temp[1];
            $date=explode("/",$meeting_date);
            $meeting_date=$date[2].$date[0].$date[1];
            $sql="insert into meetings (slide,server_id,owner_id,name,welcome_msg,record,meeting_date,meeting_time,duration,moderator_password,attendee_password,speaker,topic,status) ";
            $sql=$sql." values('".$slide."',".$server_id.",".$owner_id.",'".$name."','".$welcome_msg."','true','".$meeting_date."','".$meeting_time."',".$duration.",'".$moderatorPw."','".$attendeePw."','".$speaker."','".$topic."','reject')";
            mysql_query($sql);

            $sql = "select max(id) as max from meetings";
            $result=mysql_query($sql);
            $row = mysql_fetch_array($result);
            return($row['max']);
        }

        public function broadcast($meeting_id,$users){
            $sql="delete from broadcast where meeting_id=".$meeting_id;
            mysql_query($sql);
            foreach($users as $user_id){
                $sql="insert into broadcast (meeting_id,user_id) values(".$meeting_id.",".$user_id.")";
                mysql_query($sql);
            }
        }

        public function addInvitations($meeting_id,$users){
            $sql="delete from invitations where meeting_id=".$meeting_id;
            mysql_query($sql);
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

        public function getMeetingDetail($id){
            $sql="select a.*,b.full_name from meetings a,users b where a.owner_id=b.id and a.id=".$id;
            $result=mysql_query($sql);
            $row=mysql_fetch_array($result);
            return($row);
        }

        public function getAllMeetings($owner_id){
            $sql="select * from meetings where owner_id=".$owner_id." order by meeting_date desc";
            return(mysql_query($sql));
        }

        public function getTodayMeetings($owner_id){
            $sql="select * from meetings where owner_id=".$owner_id." and meeting_date=".date("Ymd")." order by meeting_date desc";
            return(mysql_query($sql));
        }

        public function getPastMeetings($owner_id){
            $sql="select * from meetings where owner_id=".$owner_id." and meeting_date<".date("Ymd")." order by meeting_date desc";
            return(mysql_query($sql));
        }

        public function getFutureMeetings($owner_id){
            $sql="select * from meetings where owner_id=".$owner_id." and meeting_date>".date("Ymd")." order by meeting_date desc";
            return(mysql_query($sql));
        }

        public function getAllConferences(){
            $sql="select a.*,b.full_name from meetings a,users b where a.owner_id=b.id";
            $sql=$sql." and a.meeting_date>=".date("Ymd")." order by meeting_date";
            return(mysql_query($sql));
        }

        public function getInvitations($owner_id){
            $sql="select a.*,b.full_name from meetings a,users b where a.status='accept' and a.owner_id=b.id and owner_id<>".$owner_id;
            $sql=$sql." and a.id  in (select meeting_id from broadcast where user_id=".$owner_id." and meeting_id not in ";
            $sql=$sql." (select meeting_id from invitations where user_id=".$owner_id."))";
            return(mysql_query($sql));
        }

        public function getJoinRequests($owner_id){
            $sql="select a.*,b.full_name from meetings a,users b where a.status='accept' and a.owner_id=b.id and owner_id<>".$owner_id;
            $sql=$sql." and a.id not in (select meeting_id from invitations where user_id=".$owner_id.")";
            return(mysql_query($sql));
        }

        public function getAllUsers($owner_id){
            $sql="select * from users where id<>".$owner_id." and id<>1 order by full_name";
            return(mysql_query($sql));
        }

        public function accept($meeting_id){
            $sql="update meetings set status='accept' where id =".$meeting_id;
            mysql_query($sql);
        }

        public function reject($meeting_id){
            $sql="update meetings set status='reject' where id =".$meeting_id;
            mysql_query($sql);
        }

        public function enroll($meeting_id,$user_id){
            $sql="delete from invitations where meeting_id=".$meeting_id." and user_id=".$user_id;
            mysql_query($sql);
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


        public function getBroadcast($meeting_id,$user_id){
            $flag=false;
            $sql="select * from broadcast where meeting_id=".$meeting_id." and user_id=".$user_id;
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            if($count>=1) $flag=true;
            return($flag);
        }

        public function checkEnrollment($meeting_id,$user_id){
            $flag=false;
            $sql="select * from invitations where meeting_id=".$meeting_id." and user_id=".$user_id;
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            if($count>=1) $flag=true;
            return($flag);
        }

        public function checkOldPassword($pass){
            $flag=false;
            $sql="select * from users where password='".$pass."' and id=1";
            $result=mysql_query($sql);
            $count=mysql_num_rows($result);
            if($count>=1) $flag=true;
            return($flag);
        }

        public function changePassword($pass){
            $sql="update users set password='".$pass."' where id=1";
            mysql_query($sql);
        }

    }
?>