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
<link rel="stylesheet" href="../static/index.css">
<title>Admin Login</title>
</head>

<body>
     <div class='container-fluid'>
        <div class='row'>
        <div class='col-sm-4 col-md-4 col-lg-4 mx-auto'>
         <!-- image -->
         <div class='text mb-4 text-center'>
            <img src="../images/pic4.png">
            <h2>Sign-In</h2>
        </div>  

        <!-- display error -->
        <?php if(isset($error)) {  ?>
            <div class="alert alert-danger error text-center mb-3">
                <i class="glyphicon glyphicon-warning-sign"></i>
                &nbsp; <?php echo $error; ?>
            </div>
        <?php } ?> 

        <div class='card-login'>
        <div class='card-body-login p-4'>
        <!-- Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           
            <!--username field -->
            <label for="username">Username or email</label>
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <i class="input-group-text fa fa-user-circle fa-lg"></i>
            </div>
            <input type="text" class="form-control" name="user_email" 
                   value="<?php echo htmlspecialchars($_POST['user_email'] ?? ''); ?>">
            </div>

            <!--password field -->
            <label for="password">Password</label>
            <span class="float-right"> <a href="#">Forgot password?</a> </span>
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <i class="input-group-text fa fa-key fa-lg"></i>
            </div>        
            <input type="password" class="form-control" name="password">
            </div> 

        
            <!-- Button -->
            <div class='form-group text-center mt-4'>
            <input type="hidden" name="login" value="submit">
            <button type="submit" class="btn btn-success btn-block">Sign in</button>
            </div>
        </form>
        </div>
        </div>
    </div>
    </div>
    </div>


<!-- bootstrap scripting links -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>