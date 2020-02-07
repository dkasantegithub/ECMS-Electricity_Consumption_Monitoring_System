

<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Admin Signup</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="u_login.php">
</head>

<body>
  <div class='text mb-4 text-center'>
    <h3>Create an Account</h3>
  </div>

  <div class='container-fluid'>
  <div class='row'>
  <div class='col-sm-12 col-md-9 col-lg-4 mx-auto'>
    
  <div class='card-login'>
  <div class='card-body-login p-4'>
    <form>
    
      <label for="fname">First name</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        </div>
        <input type="text" class="form-control" id="fname" name="fname">
        </div>

      <label for="lname">Last name</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        </div>
        <input type="text" class="form-control" id="lname" name="lname">
        </div>

      <label for="username">Username</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        <i class="input-group-text fa fa-user-circle fa-lg"></i>
        </div>
        <input type="text" class="form-control" id="username" name="username">
        </div>

      <label for="email">Email Address</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        <i class="input-group-text fas fa-envelope fa-lg"></i>
        </div>
        <input type="text" class="form-control" id="email" name="email">
        </div> 
      
      <label for="password">Password</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        <i class="input-group-text fa fa-key fa-lg"></i>
        </div>
        <input type="text" class="form-control" id="password" name="password">
        </div> 

      <label for="cpwd">Confirm Password</label>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        <i class="input-group-text fa fa-key fa-lg"></i>
        </div>
        <input type="text" class="form-control" id="cpwd" name="cpwd">
        </div> 
      
        <div class='form-group text-center mt-4'>
            <input type="hidden" name="signup" value="submit">
            <button type="button" class="btn btn-success btn-lg">SUBMIT</button>
            <br></br>
            <label for="password">Already have an account?</label>
            <span class="float-center"> <a href="u_login.php">Sign In</a> </span>
        </div>    
    
    </form>
  </div>
  </div>

  </div>
  </div>
  </div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>