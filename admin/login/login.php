<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="../styles/static/index.css">
    <title>ecms-admin-login</title>
</head>

<?php
    //collect data from form db and verify
    require("../control/connection.inc.php");
    
    if(isset($_POST["login"])){
        $username = $_POST["user_email"];
        $email = $_POST["user_email"];
        $password = $_POST["password"];

        try{
        if(!empty($_POST["user_email"]) && !empty($_POST["password"])){
            #fetch data from 

            $stmt = $connection->prepare("SELECT * FROM adminregister WHERE 
                                        username='$username' OR email='$email' LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //verify whether data exists
            if($stmt->rowCount() >  0){
                if(password_verify($password, $row["password"])){
                    $pwd = $row["password"];
                    $role = $row["admin_role"];
                    $admin_id = $row["admin_id"];
                    $_SESSION["id"] = $row["admin_id"];

            // verify whether user already exist
            $verify =  $connection->prepare("SELECT * FROM adminlogin WHERE user_email='$username' LIMIT 1");
            $verify->execute();
                    if(!($verify->rowCount() > 0)){
                    //insert data into login table in ecms db where user does not exist
                    $query = $connection->prepare("INSERT INTO adminlogin(user_email, pwdtoken, admin_id) 
                                                VALUES('$username','$pwd', '$admin_id')");
                    $query->execute();
                    }
                    //set session for admin
                    if($role == "admin"){
                        $admin = $role;
                        $_SESSION["username"] = $username;
                        $_SESSION["admin"] = $admin;
                        header("Location: ../dashboard/index.php");

                    //set session for superadmin
                    }elseif($role == "superadmin"){
                        $superadmin = $role;
                        $_SESSION["username"] = $username;
                        $_SESSION["superadmin"] = $superadmin;
                        header("Location: ../admin-register/register.php");
                        

                    }else{  $error = "Username or password is incorrect"; }

                }else{  $error = "Username or password is incorrect"; }

            }else{  $error = "Username or password is incorrect";  }
        }else{
            $error = "Username or password is required";
        }
    }catch(PDOException $e){
                header("Location:../error/error.php?show=dberror");
                error_log("login.php, SQL error=" .$e->getMessage());
                return;
            }
    }
?>

<body>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-sm-4 col-md-4 col-lg-4 mx-auto'>
                <!-- image -->
                <div class='text mb-4 text-center'>
                    <img src="../images/pic4.png" class="img-fluid" style="max-width: 20%;" alt="login-icon">
                    <h2>Sign-In</h2>
                </div>

                <!-- display error -->
                <?php if(isset($error)) {  ?>
                <div class="alert alert-danger error text-center mb-3">
                    <i class="fa fa-exclamation-triangle"></i>
                    &nbsp; <?php echo $error; ?>
                </div>
                <?php } ?>

                <div class='card-login'>
                    <div class='card-body-login p-4'>
                        <!-- Form -->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <!--username field -->
                            <div class="form-inline border-bottom mt-4 mb-3 text-secondary">
                                <i class="fa fa-user-circle fa-lg"></i>
                                <input type="text" class="h5 ml-3 pr-5 border-0" name="user_email"
                                    placeholder="username or email"
                                    value="<?php echo htmlspecialchars($_POST['user_email'] ?? ''); ?>">
                            </div>

                            <!--password field -->
                            <div class="form-inline border-bottom mt-4 mb-3 text-secondary ">
                                <i class="fa fa-key fa-lg"></i>
                                <input id="pwd" type="password" placeholder="password"
                                    class="h5 ml-3 pr-5 border-0 ml-1 pr-5" name="password">
                                <button type="button" id="btn" class="bg-white rounded border-0 ml-auto">
                                    <i class="fas fa-eye fa-lg text-secondary"></i>
                                </button>
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
<?php
include("../includes/scripts.php");
?>