
<?php
session_start();

$servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "mgeni";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $user="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];
    $storedOtp = $_SESSION['otp'];
    
    $sql = "SELECT * FROM sajili WHERE otp = '$storedOtp' LIMIT 1";
    $result = $conn->query($sql);
  
  if (!empty($result)) {
    $row = $result->fetch_assoc();
    // Verify password using password_verify (replace with your hashing method)
    if ($enteredOtp === $row["otp"]) {
      // Login successful (redirect or store session data)
      $user= $row["username"];
      session_start();
      $_SESSION["username"] = $user;
      header("Location: sababu.php"); // Redirect to dashboard
    }
    else {
      echo'<script language ="javascript">';
      echo 'alert("Invalid otp.");';
      echo 'window.location.href = "ingia.php"';
      echo '</script>';
    
    }
}
}
?>