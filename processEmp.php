<?php
// Start session
session_start();

// Check if phone number is submitted
if(isset($_POST['employee'])) {
    // Store the phone number in a session variable
    $_SESSION['employee'] = $_POST['employee']; 
    $_SESSION['role'] = "employee";
    $_SESSION['department'] = $_POST['department'];
    // Redirect to another page
    header("Location: calllist.php");
    exit();
} else {
    // Handle the case where phone number is not submitted
    echo "Phone number not submitted";
}