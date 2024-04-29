<?php
// Start session
session_start();

// Check if phone number is submitted
if(isset($_POST['phone'])) {
    // Store the phone number in a session variable
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['role'] = "customer";

    // Redirect to another page
    header("Location: calllist.php");
    exit();
} else {
    // Handle the case where phone number is not submitted
    echo "Phone number not submitted";
}