<?php
// Session start for potential login functionality (optional)
session_start();

/*
// Check if user is logged in (optional)
if (!isset($_SESSION['username'])) {
  header('Location: ingia.php'); // Redirect to login page if not logged in
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

// Get recent visitors (optional, adjust query and display logic)
$sql = "SELECT * FROM visitors ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

$recentVisitors = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $recentVisitors[] = $row;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitors Management System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Visitors Management System</h1>

    <?php if (isset($_SESSION['username'])): ?>
      <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
      <a href="logout.php" class="btn btn-secondary">Logout</a>
    <?php endif; ?>

    <hr>

    <a href="sajili2.php" class="btn btn-primary">Add Visitor</a>

    <hr>

    <h2>Recent Visitors</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Company</th>
          <th>Email</th>
          <th>Purpose</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentVisitors as $visitor): ?>
          <tr>
            <td><?php echo $visitor['name']; ?></td>
            <td><?php echo $visitor['company']; ?></td>
            <td><?php echo $visitor['email']; ?></td>
            <td><?php echo $visitor['purpose']; ?></td>
            <td><?php echo $visitor['date']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
