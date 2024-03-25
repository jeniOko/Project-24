<?php

/* Start session (optional, if needed for user access control)
session_start();

// Check if user has permission to edit visitor information (replace with your logic)
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: unauthorized.php"); // Redirect to unauthorized page
  exit;
}
*/
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

$errorMessage = "";
$successMessage = "";

// Process form submission (if submitted)
if (isset($_POST['identification']) && isset($_POST['name']) && isset($_POST['company']) && isset($_POST['purpose']) && isset($_POST['department'])) {
  $id = filter_input(INPUT_POST, 'identification', FILTER_SANITIZE_NUMBER_INT);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $company = mysqli_real_escape_string($conn, $_POST['company']);
  $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
  $department = mysqli_real_escape_string($conn, $_POST['department']);

  // Update query (replace with your table structure)
  $sql = "UPDATE visitors SET name = ?, company = ?, purpose = ?, department = ? WHERE identification = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $name, $company, $purpose, $department, $id);

  if ($stmt->execute()) {

    // $successMessage = "Visitor information updated successfully.";
    echo'<script language ="javascript">';
    echo 'alert("Visitor transfered sucessfully!");';
    echo 'window.location.href = "myend.php"';
    echo '</script>';

  } else {
    $errorMessage = "Error updating visitor information: " . $conn->error;
  }

  // Close statement
  $stmt->close();
}

// Close connection
$conn->close();

?>
