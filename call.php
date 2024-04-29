
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
 
  <style>
    .form-signin{
        margin-top: 20px; /* Adjust top margin as needed */
    }
    .form-signin .form-control {
        margin-bottom: 15px; /* Adjust bottom margin as needed */
    } 
  </style>
</head>
<body>
  
    <div class="container">
        <h1>Hotel Hans</h1>
        <br>
        <ul class="nav nav-tabs" id="loginTabs  mt-3">
            <li class="active"><a href="#customerLogin" data-toggle="tab">Customer</a></li>
            <li><a href="#employeeLogin" data-toggle="tab">Employee</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="customerLogin">
                <div class="card card-container">
                    <p id="profile-name" class="profile-name-card"></p>
                    <form class="form-signin" method="post" action="process.php"> 
                        <span id="reauth-email" class="reauth-email"></span>
                        <input type="text" id="phone" class="form-control" placeholder="Phone number" name="phone" required autofocus> 
                        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="employeeLogin">
                <div class="card card-container">
                    <p id="profile-name" class="profile-name-card"></p>
                    <form class="form-signin"> 
                        <span id="reauth-email" class="reauth-email"></span>
                        <input type="text" id="employeeID" class="form-control" placeholder="Employee ID" required autofocus>
                        <input type="password" id="employeePassword" class="form-control" placeholder="Password" required>
                        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div><!-- /card-container -->
    </div><!-- /container -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</body>
</html>
