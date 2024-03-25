<?php

// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mgeni";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Initialize variables and error messages
//$username = "";
//$password = "";
//$loginError = "";

// Process login form submission (if submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $username = $_POST["username"];
  $password = $_POST["password"];
  $sql = "SELECT * FROM sajili WHERE username = '$username' LIMIT 1";
  $result = $conn->query($sql);
  
  if (!empty($result)) {
    $row = $result->fetch_assoc();
    // Verify password using password_verify (replace with your hashing method)
    if ($password === $row["password"]) {
      // Login successful (redirect or store session data)
      session_start();
      $_SESSION["username"] = $username;
      header("Location: sababu.php"); // Redirect to dashboard
    }
    else {
      echo'<script language ="javascript">';
      echo 'alert("Invalid username or password.");';
      echo 'window.location.href = "ingia.php"';
      echo '</script>';
      
    }
  } else {
    $loginError = "Invalid username or password.";
  }
}
// Close connection
$conn->close();
?>

