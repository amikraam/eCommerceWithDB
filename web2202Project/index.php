<?php 
    require 'validateData.php';
?>

<html>
	<head>
		<title>Cool Japan Collectibles</title>
		<link rel="stylesheet" type="text/css" href="./css/external.css">
	</head>
	<body style="background-color: #03396c" >
		<div style="display: flex;">
			<p><img src="img/logo.png" class="logo"></p>
			<div class="login" style="width:200px; height:150px;">
				<?php
				    //Control what appears in the login box
					session_start();
					if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
						echo "<strong>Welcome ".$_SESSION['user']."</strong>";
						if($_SESSION['user_type']=='admin'){
						    echo "<a href='admin_dashboard.php' style='padding-bottom:5px;'><img src='img/button_dashboard.png' width=100px height=auto></a>";
						}else{
						    echo "<a href='profile.php' style='padding-bottom:5px;'><img src='img/button_profile.png' width=80px height=auto></a>";
						    
						}
						echo "<a href='logout.php'><img src='img/button_logout.png' width=80px height=auto></a>";
					}else{
						echo "<a href='login.php'><img src='img/button_login-register.png' width=150px height=auto></img></a>";
					}
					echo "<br>";
					echo "<a href='cart.php'><img src='img/button_view_cart.png' width=70px height=auto></img></a><br>";
				?>
				
			</div>
		</div>
		<div class="box">
			<h1 style="padding-left:30px, text-align: center;"><strong style="color:white">Products</strong></h1>
			<?php
			// Get all products
			     $p="select * from productList";
			     $p_query=mysqli_query($handlerDB, $p);
			     
			     echo "<div style='display:flex;'>";
			     
			     //Display in sets determined by $rowEnd
			     $rowStart=0;
			     $rowEnd=5;
			     while($row=mysqli_fetch_array($p_query,MYSQLI_ASSOC)){
			         
			         //Start new row if modulo is 0
			         if($rowStart%$rowEnd == 0){
			             echo "</div>";
			             echo "<div style='display:flex;'>";
			             $rowStart=0;
			         }
			         
			         //Display product
			         $img_path=getImagePath($row['image']);
			         $img=$img_path.urlencode($row['image']);
			         echo "<div class='product'>";
			         echo '<a href="product.php?id='.$row['id'].'"><img src='.$img.' height=150 width=150></img></a><br>';
			         echo '<a href="product.php?id='.$row['id'].'"><strong>'.$row['name'].'<strong></a><br>';
			         echo "RM".$row['price'];
			         echo "</div>";
			         $rowStart++;
			     }
			     echo "</div>";
			     
			     
			?>
		</div>
	</body>
</html>