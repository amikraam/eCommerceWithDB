<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="./css/forms.css">
    </head>
    <body class="container" style="background-color: #03396c;">
    <p><img src="img/logo.png" style="max-width:50%;height:auto;margin:auto"></p>
    <br>
    <h1><strong style="color:white">Registration</strong></h1>
        <div class="border">
            <form action="verifyRegister.php" method="post">
            	</p>
            		<label for="username">Username:</label>
            		<input type="text" placeholder="Enter a valid username" name="uName" id="uName" required>
            	</p>
            	<p>
            	<label for="mail">Email Address:</label>
                <input type="email" placeholder="Enter Email" name="mail" id="mail" required>
                </p>
                <p>
                <label for="pwd">Password:</label>
                <input type="password" placeholder="Enter Password" name="password" id="pwd" required>
                </p>
                <p>
                <label for="repwd">Confirm Password:</label>
                <input type="password" placeholder="Enter Password" name="retypePassword" id="repwd" onkeyup="verifyPassword();"required >
                </p>
                <div>
                    <div id="verifyAlert" style="color:white;"></div>
                </div>
                <?php
                    session_start();
                    if(isset($_SESSION['errorRegister'])){
                        echo $_SESSION['errorRegister'];
                        echo "<br>";
                        unset($_SESSION['errorRegister']);
                    }
                ?>
                <button type="submit" id="register" class="buttonStyle"><img src="img/button_register.png" height=30px width=auto></button>
            </form>
            <a href='index.php'><img src="img/button_home.png" width=auto height=50px></a>
        </div>
        <script src="webScript.js"></script>
    </body>
</html>