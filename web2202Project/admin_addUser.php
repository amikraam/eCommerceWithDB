<?php
require "validateData.php";

if(!$_POST){
    //If haven't posted, display form
    $display_block = <<<END_OF_TEXT
        <form action="$_SERVER[PHP_SELF]" method="post">
                </p>
            		<label for="username">Username:</label>
            		<input type="text" placeholder="Enter a valid username" name="uName" id="uName" required>
            	</p>
            	<p>
                	<label for="mail">Email Address:</label>
                    <input type="email" placeholder="Enter Email" name="mail" id="mail" required>
                </p>
                <p>
                    <label for="pwd">Password:</label>
                    <input type="password" placeholder="Enter Password" name="password" id="pwd" required> 
                </p>
                <p>
                    <label for="userType">User Type:</label>
                    <select name="uType" id="uType">
                    	<option value="user">User</option>
                    	<option value="admin">Admin</option>
                    </select>
                </p>
                <button type="submit" name="submit" value="send" class="buttonStyle"><img src="img/button_add-user.png" height=25px width=auto style="padding-top:5px;"></button>
        </form>
    END_OF_TEXT;
}else if($_POST){
    //Process submitted form
    
    $display_block="";
    
    //Error array
    $errors = array();
    
    //Store details into variables
    $uname=mysqli_real_escape_string($handlerDB, $_POST['uName']);
    $mail=mysqli_real_escape_string($handlerDB, $_POST['mail']);
    $pwd=mysqli_real_escape_string($handlerDB, $_POST['password']);
    $uType=mysqli_real_escape_string($handlerDB, $_POST['uType']);
    
    $errors = isValid($handlerDB,$uname, $mail, $errors);
    
    //Add user to database if no errors. Otherwise, print errors
    if(empty($errors)){
        $register="insert into userList(username,email,pwd,user_type) values('$uname','$mail', '$pwd','$uType')";
        $register_query=mysqli_query($handlerDB, $register) or die(mysqli_error($handlerDB));
        
        if($uType=="user"){
            $customerQuery="insert into customer(username) values ('$uname')";
            $customerResult=mysqli_query($handlerDB, $customerQuery) or die(mysqli_errno($handlerDB));
            
            if($customerResult){
                
            }else{
                $display_block.="Customer Error:".debugMessage($handlerDB, $display_block, $$customerResult);
            }
        }
        
        if($register_query){
            //Display success message if successful registration
            $display_block = "<p style='color:white;'>Successfully posted! <a href=\"admin_addUser.php\">Add another</a>?</p>";
        }else{
            $display_block.="Register Error:".debugMessage($handlerDB, $display_block, $register_query);
        }
        
    }else{
        
        $display_block=errorMessage($display_block, $errors);
        $tryAgain="<br><a href=\"admin_addUser.php\">Please try again</a>";
        $display_block.=$tryAgain;
    }
    
    mysqli_close($handlerDB);
}
?>
<html>
	<head>
		<title>Add User</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
	<h1><strong>Add New User</strong></h1>
		<div class="border">
			<?php echo $display_block;?>
		</div>
		
		<a href='admin_dashboard.php'><img src='img/button_dashboard.png' width=100px height=auto></a>
	</body>
</html>