<?php 

    session_start();

//connection to database
require 'customerRegistration.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.4.1/journal/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <link rel="stylesheet" href="style.css">
        <title>Customer Registration</title>
    </head>
    <body>
        <div class="jumbotron text-center">
            <h1>Customer Registration</h1>
        </div>

        <div class="card" style="width: 350px">
            <div class="card-body">
                <h4 class="card-title">Registration</h4>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div class="form-group">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" placeholder="First Name" name="customerfName" >
                            <span class="error"><?php echo $customerfNameErr ?></span><br>

                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="customerlName" >
                            <span class="error"><?php echo $customerlNameErr ?></span><br>

                        <label for="contact">Contact:</label>
                        <input type="tel" class="form-control" placeholder="Contact Number" name="customerContact" >
                            <span class="error"><?php echo $customerContactErr ?></span><br>

                        <label for="Email">Email:</label>
                        <input type="email" class="form-control" placeholder="Email" name="customerEmail" >
                            <span class="error"><?php echo $customerEmailErr ?></span><br>

                        <label for="Region">Region:</label>
                        <input type="text" class="form-control" placeholder="Region" name="customerRegion" >
                            <span class="error"><?php echo $customerRegionErr ?></span><br>

                        <label for="District">District:</label>    
                            <select>
                                <option value="">-Select-</option>
                                <option value="">Upper West</option>
                                <option value="">Upper East</option>
                                <option value="">North East</option>
                                <option value="">Northern</option>
                                <option value="">Savannah</option>
                                <option value="">Oti</option>
                                <option value="">Bono East</option>
                                <option value="">Brong Ahafo</option>
                                <option value="">Ahafo</option>
                                <option value="">Ashanti</option>
                                <option value="">Western North</option>
                                <option value="">Eastern</option>
                                <option value="">Volta</option>
                                <option value="">Greater Accra</option>
                                <option value="">Central</option>
                                <option value="">Western</option>
                            </select><br>
                            
                        <label for="GPSCode">GPSCode:</label>
                        <input type="text" class="form-control" placeholder="GPSCode" name="customerGPSCode" >
                            <span class="error"><?php echo $customerGPSCodeErr ?></span><br>

                    </div>

                    <input type="submit" name="register" value="Register">
                </form>
                
            </div>
        </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>