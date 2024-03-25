<?php

// Start session (if needed for user access control)
session_start();

// Check if user is logged in (replace with your logic)
/*$isLoggedIn = isset($_SESSION['username']);

if (!$isLoggedIn) {
  header("Location: ingia.php"); // Redirect to login page if not logged in
  exit;
}
*/
// Database connection (replace with your details)
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

$today = date("Y-m-d"); // Get today's date
$visitor = array(); // Array to store visitor information (if applicable)
$visitorId = $_SESSION['username'];
$errorMessage = "";
$successMessage = "";

// Query to retrieve visitor's appointment (replace with your logic)
// This assumes you have a table `appointments` with columns `visitor_id`, `visit_date`, etc.
$sql = "SELECT * FROM visitors WHERE ArrivalDate = ? AND username = ?"; // Adjust the query based on your table structure
$stmt = $conn->prepare($sql);

// If visitor ID is available from login or session (replace with your logic)
if (isset($_SESSION['username'])) {
  
  $stmt->bind_param("ss", $today, $visitorId);
} else {
  // Handle scenario where visitor ID is not available
  $errorMessage = "Visitor information not found. Please log in or contact the reception.";
}

// Execute query and retrieve data
if ($stmt->execute()) {
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $visitor = $result->fetch_assoc();
  } else {
    // No appointment found for today
    $errorMessage = "You don't have any appointments scheduled for today.";
  }
} else {
  $errorMessage = "Error retrieving appointment: " . $conn->error;
}

// Close connections
$stmt->close();
$conn->close();

// Handle cancellation request (if submitted)
if (isset($_POST['cancel_appointment'])) {
  // Perform cancellation logic (replace with your logic)
  // This could involve updating the `appointments` table or sending a notification
  $successMessage = "Your appointment has been cancelled successfully.";
  // Clear visitor information after cancellation
  $visitor = array();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cancel Appointment</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
  
</head>
<body>
<a href="myend.php" class="btn btn-primary" style="background: blue; width: 200px; height: 60px; ">Back to Dashboard</a><br><br><hr><br><br>
  
  <?php if (isset($_SESSION['username'])): ?>
      <p>Hello, <?php echo $_SESSION['username']; ?>! </p>
      
    <?php endif; ?>

  <div class="container mt-3">
    <h2>Cancel Appointment (<?php echo $today; ?>)</h2>
    <?php if ($errorMessage): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php elseif ($successMessage): ?>
      <div class="alert alert-success" role="alert">
        <?php echo $successMessage; ?>
      </div>
    <?php else: ?>
      <?php if (empty($visitor)): ?>
        <?php else: ?>
        <p>Are you sure you want to cancel your appointment for:</p>
        <ul>
          <li>Name: <?php echo $visitor['name']; ?></li>
          <li>Purpose: <?php echo $visitor['purpose']; ?></li>
        </ul>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <button type="submit" class="btn btn-danger" name="cancel_appointment">Cancel Appointment</button>
        </form>
        <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>
