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
            echo 'window.location.href = "myend.php"';
      echo '</script>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Send email</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    </head>
    <body>
        <H1>SEND EMAIL</H1>
        <form method="post">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" ><br>
            
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" ><br>

            <label for="name" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject"  ><br>

            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" required></textarea>
            <br>

            <input type="submit" name="submit" value="Submit">
            

    
        </form>
    </body>
</html>
        
