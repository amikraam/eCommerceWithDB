<?php
    include "dbHandler.php";

    $loginMail = mysqli_real_escape_string($handlerDB,$_POST['mail']);
    $loginPwd = mysqli_real_escape_string($handlerDB,$_POST['pwd']);

    //Check if user exist in database
    $getUser_sql="select * from userList where email='".$loginMail."' and pwd='".$loginPwd."'";
    $getUser_res=mysqli_query($handlerDB,$getUser_sql) or die(mysqli_error($handlerDB));

    session_start();

    if(mysqli_num_rows($getUser_res) == 1){
        //Login successful. Start user session
        echo "Success";
        $row=mysqli_fetch_assoc($getUser_res);
        $_SESSION['user']=$row['username'];
        $_SESSION['user_type']=$row['user_type'];
        
        if($_SESSION['user_type']=='admin'){
            mysqli_close($handlerDB);
            echo "admins go here";
            header("Location:admin_dashboard.php");
        }else{
            mysqli_close($handlerDB);
            echo "users go here";
            header("Location:index.php");
        }
        
    }else{
        //Invalid user credentials. Return to login page
        $_SESSION['errorFlag']="Invalid Login Details";
        echo $_SESSION['errorFlag'];
        mysqli_close($handlerDB);
        header("Location:login.php");
    }
?>