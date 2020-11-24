<html>
	<head>
		<title>Add New Product</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
		<h1><strong>Edit Product</strong></h1>
		<div class="border2">
			<?php
                $displayBlock= "";
                //Check for valid ID
                if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
                    $id = $_GET['id'];
                } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
                    $id = $_POST['id'];
                } else { // No valid ID, kill the script.
                    echo '<p class="error">This page has been accessed in error.</p>';
                    echo "<a href='admin_viewProduct.php'>Back to products</a>";
                    exit();
                }
                
                require 'validateData.php';
                
                //Retrieve product info
                $q="select * from productList where id='$id'";
                $r=mysqli_query($handlerDB, $q);
                
                if($_POST){
                    
                    $image_query="select image from productList where id='$id'";
                    $image_query=mysqli_query($handlerDB, $image_query);
                    
                    $image_comp=mysqli_fetch_array($image_query,MYSQLI_ASSOC);
                    $old_image=$image_comp['image'];
                    
                    $pName=mysqli_real_escape_string($handlerDB, $_POST['productName']);
                    $pCode=mysqli_real_escape_string($handlerDB, $_POST['productCode']);
                    $pPrice=mysqli_real_escape_string($handlerDB, $_POST['productPrice']);
                    $pStock=mysqli_real_escape_string($handlerDB, $_POST['productStock']);
                    $pImage= $_FILES['productImage']['name'];
                    if($pImage == null){
                        $pImage=$old_image;
                    }else {
                        
                        //Delete picture from db if not default and not currently used by other products
                        if($image_comp['image'] != "default.png"){
                            $delete_picture="select id from productList where image='$old_image'";
                            $delete_picture_query=mysqli_query($handlerDB, $delete_picture);
                            if(mysqli_num_rows($delete_picture_query)==1){
                                $delete_path="img/product/".urlencode($old_image);
                                unlink($delete_path);
                            }
                        }
                        
                        $uploadImage=basename($pImage);
                        $targetDir="img/product/";
                        $path=$targetDir.urlencode($uploadImage);
                        
                        move_uploaded_file($_FILES['productImage']['tmp_name'], $path);
                    }
                    
                    $query="update productList set name='$pName',code='$pCode',price='$pPrice',stock='$pStock',image='$pImage' where id='$id'";
                    $result=mysqli_query($handlerDB, $query);
                    
                    if($result){
                        $displayBlock = "Product updated successfully!";
                        mysqli_close($handlerDB);
                    }else{
                        $displayBlock=debugMessage($handlerDB, $displayBlock, $result);
                    }
                }
                
                if(mysqli_num_rows($r)==1){
                    
                    //Get product info
                    $row=mysqli_fetch_array($r,MYSQLI_ASSOC);
                    
                    //Show form
                    echo '<form action="" method="post" enctype="multipart/form-data">
                			<p>
                				<label for="productName">Product Name:</label>
                				<input type="text" name="productName" id="productName" value='.$row['name'].'>
                			</p>
                            <p>
                				<label for="productCode">Product Code:</label>
                				<input type="text" name="productCode" id="productCode" value='.$row['code'].'>
                			</p>
                			<p>
                				<label for="productPrice">Price:</label>
                				<input type="number" name="productPrice" id="productPrice" value='.$row['price'].'>
                			</p>
                			<p>
                				<label for="productStock">Product Stock:</label>
                				<input type="number" name="productStock" id="productStock" value='.$row['stock'].'>
                			</p>
                			<p>
                				<label for="productImage">Product Image:</label>
                				<input type="file" name="productImage" accept="image/*" value='.$row['image'].'/>
                			</p>
                            <br>
                			<button type="submit" name="submit" value="send" class="buttonStyle"><img src="img/button_update.png" height=30px width=auto></button>
                		</form>
                        <br>'.$displayBlock.'
                        <a href="admin_viewProduct.php"><img src="img/button_back.png" width=auto height=50px></a>';
                }else{
                    echo '<p class="error">This page has been accessed in error.</p>';
                    echo "<a href='admin_viewProduct.php'><img src='img/button_back.png' width=auto height=50px></a>";
                }
                ?>
		</div>
	</body>
</html>

