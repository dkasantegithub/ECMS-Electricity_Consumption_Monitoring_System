<?php
    require_once("../php-files/connection.inc.php");

    //send user to homepage when logged in
    if($user->is_loggedin()){
        $user->redirect("home.php");
    }

    //collect data from form and verify
    if(isset($_POST["login"])){
        $username = $_POST["user_email"];
        $email = $_POST["user_email"];
        $password = $_POST["password"];

        if($user->login($username, $email, $password)){
            $user->redirect("home.php");
        }else{
            $error = $user->loginError;
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="style.css">
<title>ecms-login-page</title>
</head>
<body>
     
     <div class="container-fluid">
        <div class="main">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="header">Sign In</div>

            <!-- display error -->
                <?php if(isset($error)) {  ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i>
                        &nbsp; <?php echo $error; ?>
                    </div>
                <?php } ?>

                <!-- username or email field -->
                <div class="form-group">
                    <input type="text" name="user_email" placeholder="Enter username or email" class="form-control">
                </div>

                <!-- password field -->
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter password" class="form-control">
                </div>

                <!-- button -->
                <div class="form-group">
                    <button type="submit" name="login" value="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
     </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>