<html>
	<head>
		<title>Delete Product</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
		<h1><strong>Delete Product</strong></h1>
		<div class=border2>
			<?php

                //Check for valid ID
                if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
                    $id = $_GET['id'];
                } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
                    $id = $_POST['id'];
                } else { // No valid ID, kill the script.
                    echo '<p class="error">This page has been accessed in error.</p>';
                    echo "<a href='admin_viewProduct.php'><img src='img/button_back.png' width=auto height=50px></a>";
                    exit();
                }
                
                require 'validateData.php';
                
                //Retrieve product info
                $q="select * from productList where id='$id'";
                $r=mysqli_query($handlerDB, $q);
                
                if(mysqli_num_rows($r)==1){
                    //Delete options
                    if($_POST){
                        //Product delete
                        if($_POST['sure']=="Yes"){
                            
                            //Delete image
                            $img_query="select image from productList where id='$id'";
                            $img_res=mysqli_query($handlerDB, $img_query);
                            $del_img_name=mysqli_fetch_array($img_res,MYSQLI_ASSOC);
                            $del_img=$del_img_name['image'];
                            
                            //Check whether image is default or in use by other entries
                            if($del_img_name['image'] != "default.png"){
                                $delete_picture="select id from productList where image='$del_img'";
                                $delete_picture_query=mysqli_query($handlerDB, $delete_picture);
                                if(mysqli_num_rows($delete_picture_query)==1){
                                    $delete_path="img/product/".$del_img;
                                    unlink($delete_path);
                                }
                            }
                            
                            $del_query="delete from productList where id='$id'";
                            $del_res=mysqli_query($handlerDB, $del_query);
                            if($del_res){
                                echo "Product deleted";
                                echo "<a href='admin_viewProduct.php'>Back to products</a>";
                            }else{
                                echo '<p class="error">The user could not be deleted due to system error.</p>';									 // Public message.
                                echo '<p>'.mysqli_error($handlerDB).'<br>Query:'.$del_query.'<p>';
                            }
                            
                            
                        }else{
                            //Delete cancelled
                            echo "Deletion cancelled<br>";
                            echo "<a href='admin_viewProduct.php'><img src='img/button_back.png' width=auto height=50px></a>";
                        }
                    }else{
                        //Display product to be deleted
                        $row=mysqli_fetch_array($r,MYSQLI_ASSOC);
                        $delName=$row['name'];
                        $delPath=getImagePath($row['image']);
                        $img=$delPath.$row['image'];
                        echo "<h2><strong>".$delName."</strong></h2>";
                        echo "<img src='$img' height=150 width=150 class='centerImage'></img>";
                        echo "<br>Are you sure you want to delete this product?";
                        // Create the form:
                        echo '<form action="admin_deleteProduct.php" method="post">
                	<input type="radio" name="sure" value="Yes"> Yes</input>
                	<input type="radio" name="sure" value="No" checked="checked"> No</input><br>
                	<button type="submit" name="submit" value="Submit" class="buttonStyle"><img src="img/button_submit.png" height=30px width=auto></button>
                	<input type="hidden" name="id" value="' . $id . '" />
                	</form>';
                    }
                }else{
                    echo '<p class="error">This page has been accessed in error.</p>';
                    echo "<a href='admin_viewProduct.php'><img src='img/button_back.png' width=auto height=50px></a>";
                }
            ?>
		</div>
	</body>
</html>