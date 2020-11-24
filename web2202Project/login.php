<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="./css/forms.css">
    </head>
    <body class="container" style="background-color: #03396c;">
    <p><img src="img/logo.png" style="max-width:50%;height:auto;margin:auto"></p>
    <br>
    <h1 style="color:white;text-align:center">Login</h1>
        <div style="border: 3px solid black; border-radius: 10px; margin:auto;max-width:50%; padding:5%; background-color:#007fff">
            <form action="verifyLogin.php" method="POST">
            <p>
            	<label for="mail">Email Address:</label>
                <input type="email" placeholder="Enter Email" name="mail" required>
            </p>
            <p>
            	<label for="pwd">Password:</label>
                <input type="password" placeholder="Enter Password" name="pwd" required>
            </p><br>
                <button type="submit" class="buttonStyle"><img src="img/button_login.png" width=auto height=30px></button>
            </form>
            <div style="color:white;">
            <?php
                session_start();
                if(isset($_SESSION['errorFlag'])){
                    echo $_SESSION['errorFlag'];
                    unset($_SESSION['errorFlag']);
                }
            ?>
            <br>
            <a href="register.php"><img src="img/button_register_redirect.png" width=auto height=50px></a>
            
        </div><br>
        <a href='index.php'><img src="img/button_home.png" width=auto height=50px></a>
        </div>
        
        
        <script src="webScript.js"></script>
    </body>
</html>