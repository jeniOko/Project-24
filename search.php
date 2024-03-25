

<?php

// Start session (if needed for user access control)
session_start();

// Check if user is logged in (replace with your logic)
$isLoggedIn = isset($_SESSION['username']);

if (!$isLoggedIn) {
  header("Location: ingia.php"); // Redirect to login page if not logged in
  exit;
}

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

$searchQuery = "";
$visitor = array();
$errorMessage = "";

// Check if search form is submitted
if (isset($_GET['search'])) {
  $searchQuery = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING); // Sanitize search input
  $searchType = filter_input(INPUT_GET, 'searchType', FILTER_SANITIZE_STRING); // Get search type (ID, name, or vehicle registration)

  // Prepare search query based on search type
  $sql = "SELECT * FROM visitors WHERE ";
  switch ($searchType) {
    case "identification":
      $sql .= "identification = ?";
      break;
    case "name":
      $sql .= "name LIKE ?";
      $searchQuery = "%$searchQuery%"; // Add wildcards for name search
      break;
    case "vehicle":
      $sql .= "vehicle = ?";
      break;
    default:
      $errorMessage = "Invalid search type.";
  }

  // Prepare statement and bind parameters
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $searchQuery);  

  // Execute query and retrieve data
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
      $visitor = $result->fetch_assoc();
    } else {
      $errorMessage = "Visitor not found.";
    }
  } else {
    $errorMessage = "Error retrieving visitor: " . $conn->error;
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
  <title>Visitor Search</title>
  <link rel="stylesheet" href="https://unpkg.com/boltcss/bolt.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>
<body>

<a href="myend.php" class="btn btn-primary" style="background: blue; width: 200px; height: 60px; ">Back to Dashboard</a><br><br><hr><br><br>

  <div class="container mt-3">
    <h2>Visitor Search</h2>

    <form class="mb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
      <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Search by ID, Name, or Vehicle Registration" value="<?php echo $searchQuery; ?>">
        <select class="form-select" name="searchType">
          <option value="identification">ID Number</option>
          <option value="name">Name</option>
          <option value="vehicle">Vehicle Registration</option>
        </select>
        <button type="submit" class="btn btn-primary input-group-append" data-toggle="tooltip" data-placement="bottom" title="Search">
          <i class="bi bi-search"></i> </button>
      </div>
    </form>
    <?php if ($errorMessage):?>
      <p style="text-align: center; text-transform: uppercase; text-rendering: optimizeSpeed; ">no appointment has been booked for today.</p>
    <?php endif; ?>
  </div>
  
</body>
</html>