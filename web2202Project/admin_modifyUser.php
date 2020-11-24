<?php
require "validateData.php";

//Get non-admin users
$userList_query="select username,email from userList where user_type='user'";
$userList_result=mysqli_query($handlerDB, $userList_query);

$userList=mysqli_num_rows($userList_result);

//Default form display
$formDisplay=<<<form
<form action="$_SERVER[PHP_SELF]" method="post">
<p>
<label for="user_list">Select User:</label>
<select name="sel_user" id="sel_user">
form;

$formEnd=<<<formEnd
</select>
</p>
<button type="submit" name="submit" value="modify" class="buttonStyle"><img src="img/button_modify.png" width=auto height=30px></button>
<button type="submit" name="submit" value="delete" class="buttonStyle"><img src="img/button_delete.png" width=auto height=30px></button>
</form>
formEnd;

//Set initial display as form
$displayBlock="";

//Populate form if table is not empty. Otherwise, request admin to add users to table
if($userList > 0){
    //Select user, and do action depending on button pressed
    if(!$_POST){
        $displayBlock=$formDisplay;
        while($row=mysqli_fetch_array($userList_result,MYSQLI_ASSOC)){
            //Get user list. Exclude other admins
            $displayBlock.="<option value=\"".$row['email']."\">Username: ".$row['username'].", Email: ".$row['email']."</option>";
        }
        
        $displayBlock.=$formEnd;
    }else{
        //Get selected user info
        
        switch($_POST['submit']){
            case "modify":
                //Get selected user info
                $target_user=mysqli_real_escape_string($handlerDB, $_POST['sel_user']);
                $user_info_query="select * from userList where email='$target_user'";
                $user_info_result=mysqli_query($handlerDB, $user_info_query);
                
                $user_info_data=mysqli_fetch_array($user_info_result,MYSQLI_ASSOC);
                $id=$user_info_data['id'];
                $uname=$user_info_data['username'];
                $mail=$user_info_data['email'];
                $pwd=$user_info_data['pwd'];
                
                
                $updateForm=<<<updateForm
                <form action="$_SERVER[PHP_SELF]" method="post">
                </p>
            		<label for="username">Username:</label>
            		<input type="text" value="$uname" name="newName" id="newName" required>
            	</p>
            	<p>
                	<label for="mail">Email Address:</label>
                    <input type="email" value="$mail" name="newMail" id="newMail" required>
                </p>
                <p>
                    <label for="pwd">Password:</label>
                    <input type="password" value="$pwd" name="newPwd" id="newPwd" required>
                </p>
                <p>
                    <input type="hidden" value="$id" name="user_id" id="user_id">
                </p>
                <button type="submit" name="submit" value="saveChanges" class="buttonStyle"><img src="img/button_update.png" width=auto height=30px></button>
                </form>
            updateForm;
                
                $displayBlock=$updateForm;
                break;
            case "saveChanges":
                $userId= mysqli_real_escape_string($handlerDB, $_POST['user_id']);
                $newName=mysqli_real_escape_string($handlerDB, $_POST['newName']);
                $newMail=mysqli_real_escape_string($handlerDB, $_POST['newMail']);
                $newPwd=mysqli_real_escape_string($handlerDB, $_POST['newPwd']);
                
                //Update changes
                $update_query="update userList set username='$newName',email='$newMail',pwd='$newPwd' where id='$userId'";
                $update_result=mysqli_query($handlerDB, $update_query);
                if($update_result){
                    mysqli_close($handlerDB);
                    $displayBlock="Changes saved!";
                }else{
                    $displayBlock=debugMessage($handlerDB, $displayBlock, $update_result);
                }
                break;
            case "delete":
                
                $target_user=mysqli_real_escape_string($handlerDB, $_POST['sel_user']);
                $user_info_query="select id from userList where email='$target_user'";
                $user_info_result=mysqli_query($handlerDB, $user_info_query);
                
                $user_info_data=mysqli_fetch_array($user_info_result,MYSQLI_ASSOC);
                $id=$user_info_data['id'];
                
                $deleteForm=<<<deleteForm
                <p>Are you sure you want to delete this user?</p>
                <form action="$_SERVER[PHP_SELF]" method="post">
                    <p>
                        <input type="hidden" value="$id" name="user_id" id="user_id">
                    </p>
                <button type="submit" name="submit" value="confirmDelete" class="buttonStyle"><img src="img/button_yes.png" width=auto height=30px></button>
                <button type="submit" name="submit" value="cancelDelete" class="buttonStyle"><img src="img/button_no.png" width=auto height=30px></button>
                </form>
                deleteForm;
                $displayBlock=$deleteForm;
                break;
            case "confirmDelete":
                $deleteId=mysqli_real_escape_string($handlerDB, $_POST['user_id']);
                $deleteId_query="delete from userList where id='$deleteId'";
                $deleteId_result=mysqli_query($handlerDB, $deleteId_query);
                
                if($deleteId_result){
                    mysqli_close($handlerDB);
                    $displayBlock="Delete successful!";
                }else{
                    $displayBlock=debugMessage($handlerDB, $displayBlock, $update_result);
                }
                break;
            case "cancelDelete":
                $displayBlock="Task aborted!";
                break;
            default:
                $displayBlock="No valid input!";
        }
    }
    
}else{
    $displayBlock = "No users! <a href=\"admin_addUser.php\">Add users</a>";
}
?>

<html>
	<head>
		<title>Edit User</title>
		<link rel="stylesheet" type="text/css" href="./css/forms.css">
	</head>
	<body>
		<h1><strong>Edit Users</strong></h1>
		<div class="border3">
			<?php 
    		  echo $displayBlock;
    		?>
		</div>
		<a href='admin_dashboard.php'><img src='img/button_dashboard.png' width=100px height=auto></a>
	</body>
</html>