<?php
require "dbHandler.php";

function isValid($handlerDB,$username,$email,array $errors) {
    //check if details already exist in database
    $check_mail="select * from userList where email='$email'";
    $check_mail_query=mysqli_query($handlerDB, $check_mail);
    if(mysqli_num_rows($check_mail_query)>0){
        array_push($errors, 'Email already exists!');
    }
    
    $check_uName="select * from userList where username='$username'";
    $check_uName_query=mysqli_query($handlerDB, $check_uName);
    if(mysqli_num_rows($check_uName_query)>0){
        array_push($errors,'Username already exists!');
    }
    
    return $errors;
}

function errorMessage($errorDisplay,array $errors){
    $errorDisplay="Error!<br>";
    foreach ($errors as $msg){
        $errorDisplay=$errorDisplay.$msg."<br>";
    }
    return $errorDisplay;
}

function debugMessage($handlerDB, $debugDisplay,$query){
    $public_message=<<<public_message
                <h1>System Error</h1>
                <p>Action failed due to system error</p>
            public_message;
    $debugMessage="<p>". mysqli_error($handlerDB) . '<br /><br />Query: ' . $query . '</p>';
    $debugDisplay=$public_message.$debugMessage;
    return $debugDisplay;
}

function getImagePath($image){
    if($image == "default.png"){
        return "img/";
    }else{
        return "img/product/";
    }
}
?>