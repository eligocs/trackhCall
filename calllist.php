<?php
// Start session
session_start(); 
$userId = ""; 
if(isset($_SESSION['phone'])) {
    $userId = $_SESSION['phone']; 
}   
if(isset($_SESSION['department'])) {
    $userId = $_SESSION['department']; 
}   
if(isset($_SESSION['role'])) {
    $role = $_SESSION['role']; 
}   
?>
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
    .mb-2{
        margin-bottom:4px;
    }
    li{
        list-style-type: none;
    }
    .btn{
        width:200px;
    }
    ul {
        padding: 0;
    }
    .status-circle {
        margin-top: 6px;
        margin-left: 4px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: green;
    }
    .red-circle {
        margin-top: 6px;
        margin-left: 4px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: red;
    }
    li.mb-2 {
        display: inline-flex;
    }
    #inside_call .btn_box {
    display: flex;
    gap: 5px;
    margin-top: 10px;
    padding:0 15px;
}
.call_log_cont .user_phone {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.call_log_cont {
    display: flex;
    align-items: center;
    justify-content: space-around;
    border-top: 1px solid #ddd;
    background-color: #dedede99;
    border-bottom: 1px solid #ddd;
    padding: 7px 0;
}

.call_log_cont .user_phone .user_name {
    font-weight: 600;
    margin-top: 0;
}
  </style>
  
</head>
<body>
<input type="hidden" id="userId" value="<?php echo $userId ?? ''; ?>">
<input type="hidden" id="text-element">
<div class="container"> 
        <div class="text-center">
            <h1>Hotel Hans : <?php echo !empty($_SESSION['department']) ? ucfirst($_SESSION['department']) : ''; ?></h1>
            <small><?php echo ucfirst($role); ?> Portal</small>
        </div>


            <br> 

             

            <?php if(!empty($_SESSION['role']) && $_SESSION['role'] == "customer"){ ?>
                <div id="calling_div" class="text-center">
                    <div class="call row">
                        <h1 id="heading1">Tap to call <span id="dot2"><i class="fa fa-user"></i></span></h1>
                        <ul>
                            <li class="mb-2">
                                <button class="btn btn-success reception_btn" disabled onclick="onCall('reception')"><i class="fas fa-phone"></i> Call Reception </button>
                            </li>
                            <li class="mb-2">
                                <button class="btn btn-success kitchen_btn" disabled onclick="onCall('kitchen')"><i class="fas fa-phone"></i> Call Kitchen </button>
                            </li>
                            <li class="mb-2">
                                <button class="btn btn-success store_btn" disabled onclick="onCall('store')"><i class="fas fa-phone"></i> Call Store </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php } ?>
                <?php if(!empty($_SESSION['role']) && $_SESSION['role'] == "employee"){ ?>
                <div id="second_content" class="text-center">
                    <h1 id="heading2">Call list <span id="dot2"><i class="fa fa-user"></i></span></h1>
                        <div class="row"> 
                            <div class="col-12 text-center">
                                <div class="call-box one appendhere">
                                <div class="call_log_cont">
                                    <div class="user_phone">
                                        <h4 class="user_name">Kuldeep</h4>
                                        <span class=phone_no><i class="fas fa-phone fa-rotate-90"></i> 9882269381</span>
                                    </div>
                                    <div class="call_time">
                                        <span class="time"><i class="far fa-clock"></i> 12:00 pm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php } ?>
                    <video class="secondary-video" autoplay id="remote-video"></video>
                    <video class="primary-video" autoplay muted id="local-video"></video>
    </div><!-- /container -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="./peerjs.js"></script> 
    <script src="./call.js"></script>
</body>
</html>
