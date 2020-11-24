

<html>
	<head>
		<title>View Products</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
	<h1 id="top"><strong>Product List</strong></h1>
	<a href="#end"><img src="img/button_to-bottom.png" height=30px width=auto></a>
		<div class="border4">
			<?php
                require 'validateData.php';
                
                //Display sorting method
                $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';
                
                // Determine the sorting order:
                switch($sort){
                    case 'pn':
                        $order_by='name desc';
                        break;
                    case 'pr':
                        $order_by='price desc';
                        break;
                    case 'st':
                        $order_by='stock desc';
                        break;
                    case 'cd':
                        $order_by='code desc';
                        break;
                    default:
                        $order_by='id asc';
                        $sort='id';
                        break;
                }
                
                $q="select * from productList ORDER BY $order_by";
                $r=mysqli_query($handlerDB, $q);
                
                $productList=mysqli_num_rows($r);
                
                if($productList>0){
                    $img_src="img/product/";
                    
                    
                    
                    //Table Header
                    echo '<table align="center" cellspacing="0" cellpadding="5" width="100%" style="color:white">
                <tr>
                	<td align="left"><b>Edit</b></td>
                	<td align="left"><b>Delete</b></td>
                	<td align="left"><b><a href="admin_viewProduct.php?sort=pn">Product Name</a></b></td>
                    <td align="left"><b><a href="admin_viewProduct.php?sort=cd">Product Code</a></b></td>
                	<td align="left"><b><a href="admin_viewProduct.php?sort=pr">Price</a></b></td>
                	<td align="left"><b><a href="admin_viewProduct.php?sort=st">Stock</a></b></td>
                    <td align="left"><b>Image</b></td>
                </tr>
                ';
                    //Display Products
                    $bg = '#005b96'; 
                    while($row=mysqli_fetch_array($r,MYSQLI_ASSOC)){
                        $bg = ($bg=='#005b96' ? '#011f4b' : '#005b96');
                        
                        //Encode image name to avoid display errors
                        $img_src=getImagePath($row['image']);
                        $img=$img_src.urlencode($row['image']);
                        
                        echo '<tr bgcolor="' . $bg . '">
                		<td align="left"><a href="admin_editProduct.php?id='.$row['id'].'">Edit</a></td>
                		<td align="left"><a href="admin_deleteProduct.php?id='.$row['id'].'">Delete</a></td>
                		<td align="left">'.$row['name'].'</td>
                        <td align="left">'.$row['code'].'</td>
                		<td align="left">'.$row['price'].'</td>
                		<td align="left">'.$row['stock'].'</td>
                        <td align="left"><img src='.$img.' height=150 width=150></img></td>
                        
                	</tr>
                	';
                    }
                    echo '</table>';
                }else{
                    echo "No products! <a href='admin_addProduct.php'>Please add some products</a>";
                }
                ?>
		</div>
		<a href="#top" id="end"><img src="img/button_to-top.png" height=30px width=auto></a><br><br>
		<a href='admin_dashboard.php'><img src='img/button_dashboard.png' width=auto height=50px></a>
	</body>
</html>