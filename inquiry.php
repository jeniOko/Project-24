<?php

$host = "localhost";
$username = "root"; 
$password = "";
$database = "mgeni";

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        //$header = " From : visitor management system";

    
    $sql = "INSERT INTO emails (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message' )";

    if ($conn->query($sql) === TRUE) {
        // Initialize mailer
        $mail = new PHPMailer(true);
        $mail->Host = 'smtp.gmail.com';
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = 'okothjeniffer06@gmail.com';
        $mail->Password = 'nnwp azrq bcyh xgmr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('okothjeniffer06@gmail.com', 'Administrator'); 
        $mail->addAddress($email); 

        $mail->Subject = 'Rescheduling ' . $name;
        $mail->Body = "Hello $name. Please log in to view.";

        try {
            $mail->send();
            echo'<script language ="javascript">';
            echo 'alert("Email has been sent successfully");';
            echo 'window.location.href = "wasili.html"';
      echo '</script>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
