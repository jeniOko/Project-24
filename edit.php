<?php

// Start session (optional, for maintaining user state)
session_start();

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
$visitor = array(); // Array to store visitor information

// Handle search request (if submitted)
if (isset($_POST['search_id'])) {
  $id = filter_input(INPUT_POST, 'search_id', FILTER_SANITIZE_NUMBER_INT);

  // Sanitize input to prevent SQL injection
  $id = mysqli_real_escape_string($conn, $id);

  // Search query (replace with your table structure)
  $sql = "SELECT * FROM visitors WHERE identification = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id);

  // Execute query and retrieve data
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $visitor = $result->fetch_assoc();
    } else {
      $errorMessage = "No visitor found with ID: " . $id;
    }
  } else {
    $errorMessage = "Error retrieving visitor information: " . $conn->error;
  }

  // Close statement
  $stmt->close();
}

// Close connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Visitor</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-3">
    <h2>Search Visitor</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mb-3">
        <label for="search_id">Identification Number:</label>
        <input type="number" class="form-control" id="search_id" name="search_id" required>
      </div>
      <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <?php if ($errorMessage): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php elseif (!empty($visitor)): ?>
      <script>
        // JavaScript to auto-fill the form (replace with element IDs as needed)
        document.getElementById('identification').value = "<?php echo $visitor['identification']; ?>";
        document.getElementById('name').value = "<?php echo $visitor['name']; ?>";
        document.getElementById('company').value = "<?php echo $visitor['company']; ?>"; // Assuming a 'company' field exists in the database
        document.getElementById('purpose').value = "<?php echo $visitor['purpose']; ?>";
        document.getElementById('department').value = "<?php echo $visitor['department']; ?>"; // Assuming a 'department' field exists in the database
      </script>
            <h2>Visitor Information (Auto-filled)</h2>
      <form action="edit_visitor.php" method="post">
        <div class="mb-3">
          <label for="id">Identification Number:</label>
          <input type="number" class="form-control" id="identification" name="identification" readonly value="<?php echo $visitor['identification']; ?>">
        </div>
        <div class="mb-3">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" name="name" readonly value="<?php echo $visitor['name']; ?>">
        </div>
        <div class="mb-3">
          <label for="company">Company Name:</label>
          <input type="text" class="form-control" id="company" name="company" readonly value="<?php echo $visitor['company']; ?>">
        </div>
        <div class="mb-3">
          <label for="purpose">Purpose of Visit:</label>
          <input type="text" class="form-control" id="purpose" name="purpose" readonly value="<?php echo $visitor['purpose']; ?>">
        </div>
        <div class="mb-3">
          <label for="department">Department:</label>
          <select class="form-select" id="department" name="department" required>
            <option value="">Select Department</option>
            <option value="Administration">Administration</option>
            <option value="Registry">Registry</option>
            <option value="Customer care">Customer care</option>
            <option value="Finance">Finance</option>

          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Visitor Information</button>
      </form>
    <?php endif; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
