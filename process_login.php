<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];
    $storedOtp = $_SESSION['otp'];
    $otpTimestamp = $_SESSION['otp_timestamp'];

    // Check if the OTP is still valid (within one minute)
    $validDuration = 60; // 60 seconds (1 minute)
    if (time() - $otpTimestamp <= $validDuration && $enteredOtp === $storedOtp) {
        // OTP verification successful
        // Redirect to the user's dashboard or home page
        header('Location: sababu.php');
        exit;
    } else {
        // Invalid OTP or expired
        echo 'Invalid OTP. Please try again.';
    }
}
?>
