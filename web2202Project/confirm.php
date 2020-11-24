<html>
	<head>
		<title>Order Confirmed!</title>
		<link rel="stylesheet" type="text/css" href="./css/external.css">
	</head>
	<body>
		<p class="box" style="color:white;">
			<?php
                session_start();
                unset($_SESSION["cart_item"]);
                echo "Thank you for your purchase! Your order ID is ".$_SESSION['orderID'];
            ?>
		</p>
	</body>
</html>

<a href='index.php'><img src="img/button_home.png" width=auto height=50px></a>