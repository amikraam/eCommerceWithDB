<?php 
require 'validateData.php';

session_start();
if(!isset($_SESSION['user']) && empty($_SESSION['user'])){
    header("Location:login.php");
    session_start();
    $_SESSION['errorFlag']="Access denied";
    unset($_SESSION['user']);
    unset($_SESSION['user_type']);
}

$user= $_SESSION['user'];
$displayBlock="";

if($_POST){
    $newPwd=mysqli_real_escape_string($handlerDB, $_POST['password']);
    
    $q="update userList set pwd='$newPwd' where username='$user'";
    $r=mysqli_query($handlerDB, $q);
    
    
    if($r){
        mysqli_close($handlerDB);
        $displayBlock="<p style='color:white;'>Changes saved!</p><br>";
    }else{
        $displayBlock=debugMessage($handlerDB, $displayBlock, $r);
    }
}

?>

<html>
    <head>
        <title>Update Password</title>
        <link rel="stylesheet" type="text/css" href="./css/forms.css">
    </head>
    <body>
    	<p class="middle">
    		<h1><strong>Update Password</strong></h1>
        	<div class="border">
                <form action="" method="post">
                    <p>
                    <label for="pwd">New Password:</label>
                    <input type="password" placeholder="Enter Password" name="password" id="pwd" required>
                    </p>
                    <p>
                    <label for="repwd">Confirm New Password:</label>
                    <input type="password" placeholder="Enter Password" name="retypePassword" id="repwd" onkeyup="verifyPassword();"required >
                    </p>
                    <div>
                        <div id="verifyAlert"></div>
                    </div>
                    <?php
                        if(isset($_SESSION['errorRegister'])){
                            echo $_SESSION['errorRegister'];
                            echo "<br>";
                            unset($_SESSION['errorRegister']);
                        }
                        echo $displayBlock;
                    ?>
                    <br>
                    <button type="submit" name="update" id="update" class="buttonStyle"><img src="img/button_update.png" width=auto height=30px></button>
                </form>
                <a href='profile.php'><img src="img/button_profile.png" width=auto height=50px></a>
  				<a href='index.php'><img src="img/button_home.png" class="middle" width=auto height=50px></img></a>
            </div>
    	</p>
        
        <script src="webScript.js"></script>
    </body>
</html>