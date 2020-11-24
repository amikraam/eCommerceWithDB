<?php
    include "dbHandler.php";
    
    $registerUser = mysqli_real_escape_string($handlerDB,$_POST['uName']);
    $registerMail = mysqli_real_escape_string($handlerDB,$_POST['mail']);
    $registerPwd = mysqli_real_escape_string($handlerDB,$_POST['password']);

    //Check if user exists
    $checkUser_sql="select email from userList where email='".$registerMail."'";
    $checkUser_res=mysqli_query($handlerDB,$checkUser_sql) or die(mysqli_error($handlerDB));

    session_start();
    if(mysqli_num_rows($checkUser_res) > 0){
        //Return to registration page if user exists
        $_SESSION['errorRegister']="Email already exists!";
        mysqli_close($handlerDB);
        
        header("Location:register.php");
    }else{
        //Check if username exists
        $checkUserName_sql="select username from userList where username='$registerUser'";
        $checkUserName_res=mysqli_query($handlerDB,$checkUserName_sql) or die(mysqli_error($handlerDB));
        if(mysqli_num_rows($checkUserName_res)>0){
            $_SESSION['errorRegister']="Username already exists!";
            mysqli_close($handlerDB);
            
            header("Location:register.php");
        }else{
            //Add user to database and login user session
            $addUser_sql="insert into userList(username,email,pwd,user_type) values('$registerUser','$registerMail', '$registerPwd','user')";
            $addUser_res=mysqli_query($handlerDB,$addUser_sql) or die(mysqli_error($handlerDB));
            
            
            if($addUser_res){
                //Successful registration
                $_SESSION['user']=$_POST['uName'];
                $_SESSION['user_type']="user";
                
                //Add info to Customer Database
                $customerQuery="insert into customer(username) values ('$registerUser')";
                $customerResult=mysqli_query($handlerDB, $customerQuery) or die(mysqli_errno($handlerDB));
                
                if($customerResult){
                    mysqli_close($handlerDB);
                    header("Location:index.php");
                }else{
                    echo "Customer Table Error:".mysqli_error($handlerDB);
                }
                
                
            }else{
                // Public message:
                echo '<h1>System Error</h1><br><p>You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
                echo '<p>' . mysqli_error($handlerDB) . '<br /><br />Query: ' . $addUser_sql . '</p>';
            }
            
        }
    }

    
?>