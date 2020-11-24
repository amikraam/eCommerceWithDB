if(document.getElementById("register")!=null){
    document.getElementById("register").disabled=true;
}

function verifyPassword(){
    var pwd = document.getElementById("pwd").value;
    var repwd = document.getElementById("repwd").value;

    if(pwd != repwd){
        document.getElementById("verifyAlert").innerHTML="Password does not match!";
        document.getElementById("register").disabled=true;
    }else{
        document.getElementById("verifyAlert").innerHTML="";
        document.getElementById("register").disabled=false;
    }
}


