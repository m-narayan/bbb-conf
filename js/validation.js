function trim1(str) {
    return str.replace(/^\s+|\s+$/g,"");
}

function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function server(){
    if(trim1(document.frm.server_name.value)==""){
        alert("Please enter Server Name");
        document.frm.server_name.focus();
        return false;
    }else if(trim1(document.frm.url.value)==""){
        alert("Please enter Big Blue Button URL");
        document.frm.url.focus();
        return false;
    }else if(trim1(document.frm.salt.value)==""){
        alert("Please enter Salt");
        document.frm.salt.focus();
        return false;
    }else{
        return true;
    }
}

function meeting(id){
    extension=document.frm.SMLD.value.split('.').pop().toUpperCase();
    if(trim1(document.frm.name.value)==""){
        alert("Please enter Name");
        document.frm.name.focus();
        return false;
    }else if(trim1(document.frm.welcome_msg.value)==""){
        alert("Please enter welcome message");
        document.frm.welcome_msg.focus();
        return false;
    }else if(trim1(document.frm.speaker.value)==""){
        alert("Please enter speaker");
        document.frm.speaker.focus();
        return false;
    }else if(trim1(document.frm.topic.value)==""){
        alert("Please enter topic");
        document.frm.topic.focus();
        return false;
    }else if(trim1(document.frm.duration.value)==""){
        alert("Please enter duration");
        document.frm.duration.focus();
        return false;
    }else if(extension!="" && ((extension!="PDF") && (extension!="PPT"))){
        alert("Invalid Presentation. Only PDF and PPT");
        document.frm.SMLD.focus();
        return false;
    }else{
        response="";
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                response=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","max_meeting.php?id="+id,false);
        xmlhttp.send();
        if(response==""){
            return true;
        }else{
            alert(response);
            return false;
        }
    }
}

function settings(){
    if(document.frm.user.selectedIndex==0){
        alert("Please select user");
        document.frm.user.focus();
        return false;
    }else if(trim1(document.frm.max_weekly.value)==""){
        alert("Please enter Max Conference Weekly");
        document.frm.max_weekly.focus();
        return false;
    }else if(trim1(document.frm.max_monthly.value)==""){
        alert("Please enter Max Conference Monthly");
        document.frm.max_monthly.focus();
        return false;
    }else{
        return true;
    }
}