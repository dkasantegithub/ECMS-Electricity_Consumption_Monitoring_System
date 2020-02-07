<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="style.css">
<title>Admin Login</title>
</head>

<body>
<div class='text mb-4 text-center'>
                <img src="pic4.png" width="50" height="50">
                
        </div>
    <div class='text mb-4 text-center'>
                
                <h3>Sign-Into ECMS</h3>
    </div>
     <div class='container-fluid'>
    <div class='row'>
    <div class='col-sm-2 col-md-3 col-lg-4 mx-auto'>

         
        <div class='card-login'>
        <div class='card-body-login p-4'>
  
        <!-- Form -->
        <form >
            <!-- Form title -->
            

            <!-- display error -->
            <div class="error text-center mb-3">
                
            </div>
            <!--username-->
            <label for="username">Username or email</label>
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <!--<i class="input-group-text fa fa-user-circle fa-lg"></i>-->
            </div>
            <input type="text" class="form-control" id="username" name="username">
            </div>

             <!--password -->

        
            
             <label for="password">Password</label>
            <span class="float-right"> <a href="#">Forgot password?</a> </span>
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <!--<i class="input-group-text fa fa-key fa-lg"></i>-->
            </div>        
            <input type="password" class="form-control" id="password" name="password">
            </div> 

        
            <!-- Button -->
            <div class='form-group text-center mt-4'>
            <input type="hidden" name="signin" value="submit">
            <button type="button" class="btn btn-success btn-block">Sign in</button>
            <!--<button class='btn btn-success pl-5 pr-5'>Login</button>-->
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