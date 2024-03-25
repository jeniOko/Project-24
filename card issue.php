<?php
session_start();

$isLoggedIn = isset($_SESSION['username']);

if (!$isLoggedIn) {
  header("Location: login.php"); // Redirect to login page if not logged in
  exit;
}
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

// Query to retrieve personal information
$userInfo = array();
$errorMessage = "";
$userId = $_SESSION['username'];
$sql = "SELECT staffID, name, email, phone, gender, department FROM staff WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);

if ($stmt->execute()) {
  $result = $stmt->get_result();
  if ($result->num_rows === 1) {
    $userInfo = $result->fetch_assoc();
  } else {
    $errorMessage = "User information not found.";
  }
} else {
  $errorMessage = "Error retrieving user information: " . $conn->error;
}
$stmt->close();
$conn->close();

//search button
$searchQuery = "";
$visitor = array();
$errorMessage = "";
if (isset($_GET['search'])) {
  $searchQuery = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING); 
  $searchType = filter_input(INPUT_GET, 'searchType', FILTER_SANITIZE_STRING); 

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
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $searchQuery);  
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
  $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitors Management System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="nav.css">
    <!-- sidebar menu -->
    <div id="mySidepanel" class="sidepanel">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <p style="position:center;">DASHBOARD</p>
      <a href="#">Personal Profile </a><hr style="border-color:#FF4500;">
      <a href="sajili2.php">Book an appointment</a><hr>
      <a href="search.php">search for visitor</a><hr>
      <a href="#">Cancel an Appointment</a><hr>
      <a href="transferVisitor.php">transfer Visitor</a><hr>
      <a href="#">Send Mail</a><hr>
      <a href="#">History</a><hr><br>
      <a href="logout.php">Logout</a>
    </div>
    
    <script>
    function openNav() {
      document.getElementById("mySidepanel").style.width = "250px";
    }
    function closeNav() {
      document.getElementById("mySidepanel").style.width = "0";
      }
    </script> 
</head>
<body>
<button class="openbtn" onclick="openNav()">☰ </button>
<div  class="main-content" class="container mt-5">
    <h1>Visitors Management System</h1>

    <video src="{{url_for ('C:\xampp\htdocs\24\pexels_videos_3857 (Original).mp4')}}" autoplay muted loop></video>

    <?php if (isset($_SESSION['username'])): ?>
      <p>Welcome, <?php echo $_SESSION['username']; ?>! 
    </p>
      
    <?php endif; ?>
</div>

<div class="container mt-3">
    <h2 style="text-align:center; ">Personal Information</h2>
    <?php if ($errorMessage): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php else: ?>
      <div class="card">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <i class=""></i> DEPARTMENT: <?php echo $userInfo["department"]; ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-hash"></i> ID: <?php echo $userInfo["staffID"]; ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-person"></i> Name: <?php echo $userInfo["name"]; ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-envelope"></i> Email: <?php echo $userInfo["email"]; ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-phone"></i> Phone: <?php echo $userInfo["phone"]; ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-gender-trans"></i> Gender: <?php echo $userInfo["gender"]; ?>
            </li>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- search button -->
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

