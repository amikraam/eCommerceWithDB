<?php
session_start();
if(!isset($_SESSION['user']) && empty($_SESSION['user'])){
    header("Location:login.php");
    session_start();
    $_SESSION['errorFlag']="Access denied";
    unset($_SESSION['user']);
    unset($_SESSION['user_type']);
}
?>
<html>
	<head>
		<title><?php echo $_SESSION['user']."'s Profile";?></title>
		<link rel="stylesheet" type="text/css" href="./css/external.css">
	</head>
	<body style="max-width:50%;margin:auto">
	<p><img src="img/logo.png" class="logo"></p>
	<h1><strong style="color:white; max-width:50%;margin:auto"><?php echo 'Welcome, '.$_SESSION['user'];?></strong></h1>
	<div class="box" style="width:275px; margin-left:auto;margin-right:auto;">
		<a href='user_updateDetails.php'><img src="img/button_view-and-edit-details.png" width=auto height=50px style="padding-bottom: 5px; padding-top:5px"></img></a>
		<a href='user_orderHistory.php'><img src="img/button_view-order-history.png" width=auto height=50px style="padding-bottom: 5px;"></img></a>
		<a href='user_updatePassword.php'><img src="img/button_update-password.png" width=auto height=50px></img></a><br>
		<a href='index.php'><img src="img/button_home.png" width=auto height=50px style="padding-bottom:5px;"></a>
	</div>
	</body>
</html>