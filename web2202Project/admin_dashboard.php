<?php
session_start();
if(!isset($_SESSION['user']) || empty($_SESSION['user'])|| $_SESSION['user_type']=='user'){
    session_start();
    header("Location:login.php");
    $_SESSION['errorFlag']="Access denied";
    unset($_SESSION['user']);
    unset($_SESSION['user_type']);
}
?>
<html>
	<head><title>Admin Dashboard</title></head>
	<link rel="stylesheet" type="text/css" href="./css/external.css">
	<body class="middle">
		<h1><strong style="color:white">Admin Dashboard</strong></h1>
		<h2><strong style="color:white">Welcome, <?php echo $_SESSION['user'];?></strong></h2>
		<div class="border">
    		<a href="admin_addUser.php" ><img src="img/button_add-user.png" height=50px width=auto style="padding-bottom:5px;"></a><br>
    		<a href="admin_modifyUser.php"><img src="img/button_modify-user.png" height=50px width=auto style="padding-bottom:5px;"></a><br>
    		<a href="admin_addProduct.php"><img src="img/button_add-product.png" height=50px width=auto style="padding-bottom:5px;"></a><br>
    		<a href="admin_viewProduct.php"><img src="img/button_modify-product.png" height=50px width=auto></a><br><br>
    		<a href='index.php'><img src="img/button_home.png" height=50px width=auto></a>
		</div>
		
	</body>
</html>