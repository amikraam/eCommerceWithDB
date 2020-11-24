<?php
    require 'validateData.php';
    $displayBlock="";
    if($_POST){
        
        $pName=mysqli_real_escape_string($handlerDB, $_POST['productName']);
        $pCode=mysqli_real_escape_string($handlerDB, $_POST['productCode']);
        $pPrice=mysqli_real_escape_string($handlerDB, $_POST['productPrice']);
        $pStock=mysqli_real_escape_string($handlerDB, $_POST['productStock']);
        $pImage="default.png";
        
        //Upload file if image is set
        if(!empty($_FILES['productImage']['name'])){
            $pImage= $_FILES['productImage']['name'];
            $uploadImage=basename($pImage);
            $targetDir="img/product/";
            $path=$targetDir.urlencode($uploadImage);
            
            move_uploaded_file($_FILES['productImage']['tmp_name'], $path);
        }
        
        //Insert product into database
        $query="insert into productList(name,code, price,stock,image) values ('$pName','$pCode','$pPrice','$pStock','$pImage')";
        $result=mysqli_query($handlerDB, $query) or die(mysqli_error($handlerDB));
        
        if($result){
            $displayBlock="Product Added Successfully!<br>";
            mysqli_close($handlerDB);
        }else{
            $display_block=debugMessage($handlerDB, $display_block, $result);
        }
        
        
    }
?>

<html>
	<head>
		<title>Add New Product</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
	<h1><strong style="color:white">Add Product</strong></h1>
    	<div class="border2">
    		<form action="" method="post" enctype='multipart/form-data'>
    			<p>
    				<label for="productName">Product Name:</label>
    				<input type="text" name="productName" id="productName">
    			</p>
    			<p>
    				<label for="productCode">Product Code:</label>
    				<input type="text" name="productCode" id="productCode">
    			</p>
    			<p>
    				<label for="productPrice">Price:</label>
    				<input type="number" name="productPrice" id="productPrice">
    			</p>
    			<p>
    				<label for="productStock">Product Stock:</label>
    				<input type="number" name="productStock" id="productStock">
    			</p>
    			<p>
    				<label for="productImage">Product Image:</label>
    				<input type='file' name='productImage' accept="image/*"/>
    			</p>
    			<button type="submit" name="submit" value="send" class="buttonStyle"><img src="img/button_add-product.png" height=25x width=auto style="padding-top:10px;"></button>
    		</form>
    		<?php echo $displayBlock?>
    	</div>
		<br>
		<a href='admin_dashboard.php'><img src='img/button_dashboard.png' width=100px height=auto></a>
	</body>
</html>