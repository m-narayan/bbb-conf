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

function meeting(){
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
    }else{
        return true;
    }
}
