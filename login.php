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


// Process login form submission (if submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $username = $_POST["username"];
  $password = $_POST["password"];
  $department="";
  $sql = "SELECT * FROM staff WHERE username = '$username' LIMIT 1";
  $result = $conn->query($sql);
  
  if (!empty($result)) {
    $row = $result->fetch_assoc();
    $department=$row["department"];
    // Verify password using password_verify (replace with your hashing method)
    if ($password === $row["password"]) {
      // Login successful (redirect or store session data)
      session_start();
      $_SESSION["username"] = $username;
      $_SESSION["department"]= $department;


      header("Location: myend.php"); // Redirect to dashboard
    }
    else {
      echo'<script language ="javascript">';
      echo 'alert("Invalid username or password.");';
      echo 'window.location.href = "login.php"';
      echo '</script>';
      
    }
  } else {
    $loginError = "Invalid username or password.";
  }
}
// Close connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2>DEAR STAFF MEMBER,</h2>
    <h3> Hello. Welcome back. Now access the system by loging in</h3>
    <form id="login-form" method="post" >
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" id="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>

  <div class="container mt-5" id="signup">
          <h2>YOU DON'T HAVE AN EXISTING ACCOUNT?</h2>
    <p>Visit the ICT department</p>
    <!-- <br> -->
    <!-- <a href="http://localhost:3000/andikisha.php"> Register for a new account here </a> -->
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>

      
      

   

