<?php
    require 'validateData.php';

    $display_block="";
    
    session_start();
    
    $user=mysqli_real_escape_string($handlerDB, $_SESSION['user']);
    
    //get Customer from table
    $customerQuery="select * from customer where username='$user'";
    $customerRes=mysqli_query($handlerDB, $customerQuery);
    
    $customerDetails=mysqli_fetch_array($customerRes, MYSQLI_ASSOC);
    
    if($_POST){
        
        
        if($customerRes){
            $fn=mysqli_real_escape_string($handlerDB, $_POST['fName']);
            $ln=mysqli_real_escape_string($handlerDB, $_POST['lName']);
            $a1=mysqli_real_escape_string($handlerDB, $_POST['add1']);
            $a2=mysqli_real_escape_string($handlerDB, $_POST['add2']);
            $a3=mysqli_real_escape_string($handlerDB, $_POST['add3']);
            $zip=mysqli_real_escape_string($handlerDB, $_POST['zip']);
            $cty=mysqli_real_escape_string($handlerDB, $_POST['city']);
            $stt=mysqli_real_escape_string($handlerDB, $_POST['state']);
            $country=mysqli_real_escape_string($handlerDB, $_POST['country']);
            
            $profileQuery="update customer set fname='$fn',lname='$ln',add1='$a1',add2='$a2',add3='$a3',zipcode='$zip',city='$cty',state='$stt',country='$country' where username='$user'";
            $profileRes=mysqli_query($handlerDB, $profileQuery);
            
            if($profileRes){
                $customerQuery="select * from customer where username='$user'";
                $customerRes=mysqli_query($handlerDB, $customerQuery);
                $customerDetails=mysqli_fetch_array($customerRes, MYSQLI_ASSOC);
                $display_block="<p style='color:white'>Changes saved!</p>";
                mysqli_close($handlerDB);
            }else{
                $display_block=debugMessage($handlerDB, $display_block, $profileQuery);
            }
        }else{
            $display_block=debugMessage($handlerDB, $display_block, $customerQuery);
        }
    }
?>
<html>
	<head>
		<title>Edit Details</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
		<h1><strong>Your Details</strong></h1>
		<div class="border">
			<form action="" method="post">
				<p>
					<label for="fName">First Name:</label>
					<input type="text" name="fName" id="fName" value="<?php echo $customerDetails['fname'];?>">
				</p>
				<p>
					<label for="lName">Last Name:</label>
					<input type="text" name="lName" id="lName" value="<?php echo $customerDetails['lname'];?>">
				</p>
				<p>
					<label for="add1">Address (Line 1):</label>
					<input type="text" name="add1" id="add1" value="<?php echo $customerDetails['add1'];?>">
				</p>
				<p>
					<label for="add2">Address (Line 2):</label>
					<input type="text" name="add2" id="add2" value="<?php echo $customerDetails['add2'];?>">
				</p>
				<p>
					<label for="add3">Address (Line 3):</label>
					<input type="text" name="add3" id="add3" value="<?php echo $customerDetails['add3'];?>">
				</p>
				<p>
					<label for="zipCode">Zip Code:</label>
					<input type="number" name="zip" value="<?php echo $customerDetails['zipcode'];?>">
				</p>
				<p>
					<label for="city">City:</label>
					<input type="text" name="city" id="city" value="<?php echo $customerDetails['city'];?>">
				</p>
				<p>
					<label for="state">State:</label>
					<input type="text" name="state" id="state" value="<?php echo $customerDetails['state'];?>">
				</p>
				<p>
					<label for="country">Country:</label>
					<select id="country" name="country" style="width:150px">
    					<?php 
    					    $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        				    foreach ($countries as $key => $value) {
        					    if ($value == $customerDetails['country']) {
        					        echo('<option selected="selected" value='.$value.'>'.$value.'</option>');
        					    } else {
        					        echo('<option value='.$value.'>'.$value.'</option>');
        					    }
        					}
    					?>
                    </select>
				</p>
				<button type="submit" id="submitDetails" class="buttonStyle"><img src="img/button_update.png" height=30px width=auto></button>
			</form>
			<?php
			 if(isset($_SESSION['addressError'])){
			     echo $_SESSION['addressError'];
			     unset($_SESSION['addressError']);
			 }
			 echo $display_block;
			 
			?>
		</div><br>
		<a href='profile.php'><img src="img/button_profile.png" width=auto height=50px></a>
  		<a href='index.php' class="middle"><img src="img/button_home.png" class="middle" width=auto height=50px></img></a>
	</body>
</html>