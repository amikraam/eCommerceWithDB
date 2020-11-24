<html>
	<head>
		<title>Order History</title>
		<link rel="stylesheet" type="text/css" href="./css/external.css">
	</head>
	<body class="middle">
		<h1 style="color:white;" class="middle">Order History</h1>
		<div class="border">
		<?php
            require 'validateData.php';
            session_start();
            
            $user=mysqli_real_escape_string($handlerDB, $_SESSION['user']);
            
            //Get order history from database
            $oh_q="select * from orderHistory where username='$user' order by orderid";
            $oh_r=mysqli_query($handlerDB, $oh_q) or die(mysqli_error($handlerDB));;
            
            //Display order history
            $debugMessage="";
            if(mysqli_num_rows($oh_r)>0){
                if($oh_r){
                    $current_id=null;
                    $bg = '#005b96'; 
                    echo "<table><tbody style='color:white;'>";
                    while($row=mysqli_fetch_array($oh_r,MYSQLI_ASSOC)){
                        
                        $code=mysqli_real_escape_string($handlerDB, $row['code']);
                        $productQ="select name,image from productList where code='$code'";
                        $productR=mysqli_query($handlerDB, $productQ);
                        
                        $productInfo=mysqli_fetch_array($productR,MYSQLI_ASSOC);
                        
                        //Display "Unknown" if product information cannot be retrieved
                        if(!isset($productInfo['name'])){
                            $productName="Unknown Product";
                        }else{
                            $productName=$productInfo['name'];
                        }
                        
                        if(!isset($productInfo['image'])){
                            $imgName="default.png";
                            $imgPath=getImagePath($imgName);
                            $imgPath.=urlencode($imgName);
                        }else{
                            $imgPath=getImagePath($productInfo['image']);
                            $imgPath.=urlencode($productInfo['image']);
                        }
                        
                        if($row['orderid'] != $current_id){
                            $current_id = $row['orderid'];
                            $current_date=strtotime($row['orderDate']);
                            echo "<tr bgcolor='.$bg.'><td colspan=5 align=left></td></tr>";
                            echo "<tr>";
                            echo "<td colspan=5 align=left></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=5 align=left><strong>Order ID: ".$current_id."</strong></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=5 align=left><strong>Date: ".date("d F yy, h:ia T",$current_date)."</strong></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=5 align=left><strong>Ship to: ".$row['address']."</strong></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=5 align=left><strong>Total (RM): ".$row['total']."</strong></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th><strong>Image</strong></th>";
                            echo "<th><strong>Name</strong></th>";
                            echo "<th><strong>Code</strong></th>";
                            echo "<th><strong>Price (RM)</strong></th>";
                            echo "<th><strong>Quantity</strong></th>";
                            echo "</tr>";
                            
                        }
                        echo "<tr>";
                        echo "<td align=right><img src=".$imgPath." height=75px width=75px></td>";
                        echo "<td align=right>".$productName."</td>";
                        echo "<td align=right>".$row['code']."</td>";
                        echo "<td align=right>".$row['price']."</td>";
                        echo "<td align=right>".$row['quantity']."</td>";
                        echo "</tr>";
                        
                        
                    }
                    echo "</tbody></table>";
                }else{
                    $debugMessage=debugMessage($handlerDB, $debugMessage, $oh_q);
                }
            }else{
                echo "You haven't bought anything yet!<br>";
            }
            
            
            echo $debugMessage;
        ?>
        </div><br>

 <a href='profile.php'><img src="img/button_profile.png" width=auto height=50px></a>
  <a href='index.php' class="middle"><img src="img/button_home.png" class="middle" width=auto height=50px></img></a>
	</body>
</html>

