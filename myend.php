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

// Functions

function getVisitorsToday($conn) {
  $dept= $_SESSION['department'];
  $sql = "SELECT * FROM visitors WHERE 	ArrivalDate = CURRENT_DATE AND department= '$dept' ";
  $result = $conn->query($sql);
  $todayVisitors = [];
  if (!empty($result) && $result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
  } else {
    return [];
  }
}
$todayVisitors = getVisitorsToday($conn);


function getrecentVisitors($conn) {
  $dept= $_SESSION['department'];
  $sql = "SELECT * FROM visitors WHERE 	ArrivalDate < CURRENT_DATE AND department= '$dept' ";
  $result = $conn->query($sql);
  $recentVisitors = [];
  if (!empty($result) && $result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
  } else {
    return [];
  }
}
$recentVisitors = getrecentVisitors($conn);


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitors Management System</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
  <style>
    body {
  font-family: "Lato", sans-serif;
}

.sidepanel  {
  width: 300px;
  position: fixed;
  z-index: 1;
  height: 50hv;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  align-items:  baseline;
  background-color: aliceblue;
  overflow-x: hidden;
  transition: 0.8s;
  padding-top: 60px;
}

.sidepanel a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 20px;
  text-transform: uppercase;
  color: #3498DB;
  display: block;
  transition: 0.8s;
}

.sidepanel a:hover {
  color: #FF4500;
}

.sidepanel .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #003399;
  color: white;
  padding: 10px 15px;
  border: none;
  position: absolute;
  top: 10px;
  left: 10px;
}

.openbtn:hover {
  background-color:#3498DB;
}

.main-content {
      margin-left: 300px;
      padding: 20px;
}
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
  
    <!-- sidebar menu -->
    <div id="mySidepanel" class="sidepanel">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <h3 style=" color: #FF4500; text-align: center; ">DASHBOARD</h3>
      <a href="#">Personal Profile </a><hr style="border-color:#FF4500;">
      <a href="sajili2.php">Book an appointment</a><hr>
      <a href="search.php">Search</a><hr>
      <a href="cancel.php">Cancel Appointment</a><hr>
      <a href="edit.php">Transfer</a><hr>
      <a href="form.html">Send Mail</a><hr>
      <a href="#recent">History</a><hr>
      <a href="logout.php" class="btn btn-secondary">Logout</a>
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
      <p>Welcome, <?php echo $_SESSION['username']; ?>! </p>
      <p>Your department: <?php echo $_SESSION['department']; ?></p>
      
    <?php endif; ?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
    
</head>
<body>

  <!-- PERSONAL INFO -->
  <?php

//Start session (if needed)
//session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);

//if (!$isLoggedIn) {
  //header("Location: ingia.php"); // Redirect to login page if not logged in
  //exit;
//}

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>
<body>
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

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZSjPp/tNKTY1mPOu7+ACj7FldEyOJik+aY57EdrJyBuVESUnqZNLUj7V8k/v" crossorigin="anonymous"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>
<body>
  


  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZSjPp/tNKTY1mPOu7+ACj7FldEyOJik+aY57EdrJyBuVESUnqZNLUj7V8k/v" crossorigin="anonymous"></script>
</body>
</html>

<br><br><hr><br><br>
<!-- search button -->
<?php


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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>
<body>
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



<body>
    <br><br><br>
<h2>Today's Visitors</h2>
<?php if (count($todayVisitors) > 0): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Company</th>
          <th>Purpose</th>
          <th>Status</th>
          <th>Comment</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($todayVisitors as $visitor): ?>
            <tr>
                <td><?php echo $visitor['name']; ?></td>
                <td><?php echo $visitor['company']; ?></td>
                <td><?php echo $visitor['purpose']; ?></td>
                <td><?php echo $visitor['status']; ?></td>
                <td><?php echo $visitor['comment']; ?></td>

                
                </tr>
        <?php endforeach; ?>
        <script src="visitor_management.js"></script></body>
      </tbody>
    </table>
    <?php else: ?>
      <p style="text-align: center; text-transform: uppercase; text-rendering: optimizeSpeed; ">no appointment has been booked for today.</p>
    <?php endif; ?>

</html>
<br><br><br>
    <hr>

    <a href="addVisitor.php" class="btn btn-primary">Add Visitor</a>

    <br><br><br><br><br><br>  
    <hr>

    <h2>Generate Visitor Report</h2>
                <form method="post" id="report-form" class="mb-3" action="report.php">
                <div class="row">
                    <div class="col-md-6">
                        <label for="startDate">Start Date:</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <div class="col-md-6">
                        <label for="endDate">End Date:</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" required>
                    </div>
                    <button type="submit" id="generate-report" class="btn btn-primary">Generate Report</button>

                  </form>
                    <div id= "report-data" ></div>
                </div><br><br><br><hr><hr><br><br><br>
                
            

                <h2 id="recent">Recent Visitors(HISTORY)</h2>
    <?php if (count($recentVisitors) > 0): ?>
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
    <?php else: ?>
      <p style="text-align: center; text-transform: uppercase; text-rendering: optimizeSpeed; ">no recent visits to this department</p>
    <?php endif; ?>

    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
