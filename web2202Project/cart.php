<html>
	<head>
		<title>Shopping Cart</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
	<div class="border3">
		<?php
            require 'validateData.php';
            session_start();
            
            //Get cart item and initialize total price
            if(isset($_SESSION['cart_item'])){
                $item_total = 0;
            }
            
            if(!empty($_GET["action"])){
                if(!empty($_SESSION["cart_item"])) {
                    foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);
                            if(empty($_SESSION["cart_item"]))
                                unset($_SESSION["cart_item"]);
                    }
                }
            }
            
            //Populate cart items. Returns a message if cart is empty
            if(!empty($_SESSION["cart_item"])){
                echo "<table style='border-spacing: 15px; color:white'>
            	<tbody>
            		<tr>
                        <th><strong>Image</strong></th>
            			<th><strong>Name</strong></th>
            			<th><strong>Code</strong></th>
            			<th><strong>Quantity</strong></th>
            			<th><strong>Unit Price <br>(RM)</strong></th>
            			<th><strong>Action</strong></th>
            		</tr>";
                foreach ($_SESSION["cart_item"] as $item){
                    
                    $imgCode=mysqli_real_escape_string($handlerDB, $item["code"]);
                    $imgQ="select image from productList where code='$imgCode'";
                    $imgR=mysqli_query($handlerDB, $imgQ);
                    
                    $img=mysqli_fetch_assoc($imgR);
                    
                    $imgPath=getImagePath($img['image']);
                    $imgPath.=urlencode($img['image']);
                    
                    echo "<tr>";
                    echo "<td><img src=".$imgPath." width=75px height=75px></td>";
                    echo "<td>".$item["name"]."</td>";
                    echo "<td>".$item["code"]."</td>";
                    echo "<td align=right>".$item["quantity"]."</td>";
                    echo "<td align=right>".$item["price"]."</td>";
                    echo '<td><a href="cart.php?action=remove&code='.$item["code"].'"><img src="img/button_remove.png" height=20px width=auto></a></td>';
                    echo "</tr>";
                    $item_total+=($item["price"]*$item["quantity"]);
                }
                echo '<tr>
            			<td colspan="5" align=right><strong>Total:</strong>RM:'.$item_total.'</td>
            		</tr>
            	</tbody>
            </table>';
            }else{
                echo "Cart is empty! Please add some products!<br>";
            }
            
            if(isset($_POST['cartButton'])){
                //Check which button was pressed
                switch ($_POST['cartButton']){
                    case "empty":
                        //Empty the cart
                        unset($_SESSION["cart_item"]);
                        header("Location:cart.php");
                        break;
                    case "checkout":
                        //Checkout items. Does nothing if no items in cart
                        if(!empty($_SESSION["cart_item"])){
                            //If logged in, generate order id and add items to user order history. Otherwise, redirect to login page
                            if(!isset($_SESSION['user']) || empty($_SESSION['user'])|| $_SESSION['user_type']=='admin'){
                                header("Location:login.php");
                                $_SESSION['errorFlag']="Please login first";
                                unset($_SESSION['user']);
                                unset($_SESSION['user_type']);
                            }else{
                                //Get customer address. If blank, redirect to profile to set address
                                
                                $user=mysqli_real_escape_string($handlerDB, $_SESSION['user']);
                                
                                $addressQuery="select add1,add2,add3,zipcode,city,state,country from customer where username='$user'";
                                $addressRes=mysqli_query($handlerDB, $addressQuery);
                                
                                $getAddress=mysqli_fetch_assoc($addressRes);
                                $validAddress=true;
                                $userAddress="";
                                
                                foreach ($getAddress as $key=>$value){
                                    if($key=="add2" && $value==null||$key=="add2" && $value==""||$key=="add3" && $value==null||$key=="add2" && $value==""){
                                        continue;
                                    }else{
                                        if($value==NULL||$value==""){
                                            $userAddress="";
                                            $validAddress=false;
                                            break;
                                        }else{
                                            $userAddress.=$value.",";
                                        }
                                    }
                                }
                                
                                if(!$validAddress){
                                    $_SESSION['addressError']="<p style='color:white;'>Please fill out your address before making a purchase</p>";
                                    header("Location:user_updateDetails.php");
                                }else{
                                    //Unique Order ID algorithm: Set the last 3 digits as user id in database, and a random value between 100 and 999 as the first three digits.
                                    $q="select id from userList where username='$user'";
                                    $r = mysqli_query($handlerDB, $q);
                                    $row=mysqli_fetch_array($r,MYSQLI_ASSOC);
                                    if($row['id'] < 100){
                                        if($row['id'] < 10){
                                            $digits="00".$row['id'];
                                        }else{
                                            $digits="0".$row['id'];
                                        }
                                    }else{
                                        $digits=$row['id'];
                                    }
                                    
                                    $_SESSION['orderID']=time().mt_rand(100,999).$digits;
                                    $oid=mysqli_real_escape_string($handlerDB, $_SESSION['orderID']);
                                    $add=mysqli_real_escape_string($handlerDB, $userAddress);
                                    
                                    foreach ($_SESSION["cart_item"] as $item){
                                        $code=mysqli_real_escape_string($handlerDB, $item["code"]);
                                        $quantity=mysqli_real_escape_string($handlerDB, $item["quantity"]);
                                        $price=mysqli_real_escape_string($handlerDB, $item["price"]);
                                        
                                        //Insert new value into order history
                                        $oh_query="insert into orderHistory(orderid,username,orderDate,address, code,price,quantity,total) values ('$oid','$user',now(),'$add','$code','$price','$quantity','$item_total')";
                                        $oh_result=mysqli_query($handlerDB, $oh_query);
                                        
                                        //Update stock quantity
                                        $stock_query="select stock from productList where code='$code'";
                                        $stock_result=mysqli_query($handlerDB, $stock_query);
                                        $row=mysqli_fetch_array($stock_result,MYSQLI_ASSOC);
                                        
                                        $new_stock=$row['stock'] - $quantity;
                                        $updateStock_query="update productList set stock='$new_stock' where code='$code'";
                                        $updateStock_result=mysqli_query($handlerDB, $updateStock_query);
                                        
                                        if($oh_result && $updateStock_result){
                                            
                                        }else{
                                            echo '<p>' . mysqli_error($handlerDB) . '<br /><br />Query: ' . $oh_query . $updateStock_query.'</p>';
                                        }
                                    }
                                    
                                    mysqli_close($handlerDB);
                                    header("Location:confirm.php");
                                }
                                
                                
                            }
                        }
                        break;
                }
            }
            ?>
	</div>
        <form method="post" action="cart.php">
        <button type="submit" name="cartButton" value="empty" class="buttonStyle"><img src="img/button_empty-cart.png" height=50px width=auto style="padding-top:10px;"></button> 
        <button type="submit" name="cartButton" value="checkout" class="buttonStyle"><img src="img/button_checkout.png" height=50px width=auto></button> 
</form>
<a href='index.php'><img src="img/button_home.png" class="middle" width=auto height=50px></img></a>
	</body>
</html>

