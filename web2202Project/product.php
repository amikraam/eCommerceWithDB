<?php 
    //Check for valid ID
    if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
        $id = $_GET['id'];
    } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
        $id = $_POST['id'];
    } else { // No valid ID, kill the script.
        echo '<p class="error">This page has been accessed in error.</p>';
        echo "<a href='index.php'>Back to home</a>";
        exit();
    }
    
    require 'validateData.php';
    
    //Retrieve product info
    $q="select * from productList where id='$id'";
    $r=mysqli_query($handlerDB, $q);
    
    $row=mysqli_fetch_array($r,MYSQLI_ASSOC);
    
    session_start();
    $maxStock=true;
    if($row['stock']>0){
        $maxStock=false;
    }
    if(!empty($_SESSION['cart_item'])){
        if(isset($_SESSION['cart_item'][$row['code']])){
            if($_SESSION["cart_item"][$row['code']]["quantity"] >= $row['stock']){
                $maxStock=true;
            }
        }
    }
    $cartMessage="";
    $debugMessage="Debug Messages go here";
    
    if($_POST){
        //Add item to cart
        $itemArray= array($row['code']=>array('name'=>$row['name'],'code'=>$row['code'],'quantity'=>$_POST['quantity'],'price'=>$row['price']));
        //Check if cart is empty. If empty, add to cart. Otherwise, update cart
        if(!empty($_SESSION['cart_item'])){
            
            //Check if item is already in cart. If yes, update. Otherwise, add new item to cart
            if(isset($_SESSION['cart_item'][$row['code']])){
                foreach($_SESSION["cart_item"] as $k => $v) {
                    if(strval($row['code']) == $k){
                        $debugMessage .= "Item found <br>";
                        $_SESSION["cart_item"][$k]["quantity"] += $_POST['quantity'];
                        if($_SESSION["cart_item"][$k]["quantity"] >= $row['stock']){
                            $maxStock=true;
                        }
                    }
                        
                }
            }else{
                $_SESSION['cart_item'] = array_merge($_SESSION['cart_item'],$itemArray);
                if($_SESSION["cart_item"][$row['code']]["quantity"] >= $row['stock']){
                    $maxStock=true;
                }
            }
        }else{
            $_SESSION['cart_item']=$itemArray;
        }
        $cartMessage="<strong style='color:white;'>Item added to cart!</strong><br><a href='cart.php'><img src='img/button_view_cart.png' height=40px width=auto></a>";
    }
?>

<html>
    <head>
        <title>Product</title>
        <link rel="stylesheet" type="text/css" href="./css/external.css">
    </head>
    <body style="background-color: #03396c">
        <div style="display: flex">
        	<div class="productImage">
        	<?php 
        	   $img_path="img/product/";
        	   if($row['image']=="default.png"){
        	       $img_path="img/";
        	   }
        	   $img=$img_path.urlencode($row['image']);
        	   echo "<img src='$img' height=300 width=300></img>";
        	?>
        	</div>
        	<div class="productBorder">
        		<h1><strong style="color:white;"><?php echo $row['name'];?></strong></h1><br>
				<h3 style="color:white;">Price:<?php echo "RM".$row['price'];?></h3><br>
				<?php 
				if($row['stock']==0 || $maxStock == true){
				    echo '<img src="img/no_stock.png">';
				}else{
				    echo '<form method="post" action="product.php?action=add&code='.$row['code'].'">';
				    echo '<label for="quantity" style="color:white;">Quantity (Max '.$row['stock'].'):</label>';
				    echo '<input type="number" id="quantity" name="quantity" min="1" max="'.$row['stock'].'" value="1"><br>';
				    echo '<br>';
				    echo '<button type="submit" class="buttonStyle" name="addCart" value="addCart"><img src="img/button_cart.png"></button>';
				    echo '<input type="hidden" name="id" value="'.$row['id'].'">';
				    echo '</form>';
				    //echo $debugMessage;
				    echo $cartMessage;
				}
				?>
        	</div>
        </div>
        <br>
        <a href='index.php'><img src="img/button_home.png" class="center"></img></a>
    </body>
</html>