

<?php

session_start();


// Database connection (replace with your details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mgeni";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//today's visitors

function getVisitorsToday($conn) {
  $today = date("Y-m-d");
  $userId = $_SESSION['username'];
  $sql= "SELECT * FROM visitors WHERE username='$userId'AND ArrivalDate = CURRENT_DATE" ;
  $result = $conn->query($sql);
  $todayVisitors = [];
  if (!empty($result) && $result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
  } else {
    return [];
  }
}

// Get today's visitors
$todayVisitors = getVisitorsToday($conn);


// Get recent visitors (optional, adjust query and display logic)
function getrecentVisitors($conn) {
  $userId = $_SESSION['username'];
  $sql = "SELECT * FROM visitors WHERE username='$userId' AND ArrivalDate < CURRENT_DATE ORDER BY ArrivalDate DESC LIMIT 3";
  $result = $conn->query($sql);
  $recentVisitors = [];
  if (!empty($result)) {
    while ($row = $result->fetch_assoc()) {
      $recentVisitors[] = $row;
    }
  }else {
    return [];
  }
}
$recentVisitors = getrecentVisitors($conn);

$conn->close();
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
  text-transform: uppercase;
  font-size: 20px;
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
      <a href="#info">Personal Profile </a><hr style="border-color:#FF4500;">
      <a href="sajili2.php">Book Appointment</a><hr>
      <a href="userCancel.php">Cancel Appointment</a><hr>
      <a href="#recent">History</a><hr>
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

// Get user ID from session (replace with your logic)
$userId = $_SESSION['username'];

// Query to retrieve user information
$sql = "SELECT VisitorID, name, email, phone, gender FROM sajili WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId); // Bind user ID to prevent SQL injection

// Execute query and retrieve data
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

// Close connections
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
  <div class="container mt-3" id="info">
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
              <i class="bi bi-hash"></i> ID: <?php echo $userInfo["VisitorID"]; ?>
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






<!-- #region -->
<html>
  <body>
<hr><br>

<a href="sajili2.php" class="btn btn-primary" >Book an appointment</a>


<br><br><br> 
<hr>

    <br><br><br>
<h2 style="text-transform: uppercase; text-align:center; ">Today's appointment</h2>
<?php if (count($todayVisitors) > 0): ?>
    <table class="table table-striped" action="recentVisitors.php" >
      <thead>
        <tr>
          <th>TIME</th>
          <th>OFFICE</th>
          <th>PURPOSE</th>
          <th>STATUS</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($todayVisitors  as $visitor): ?>
            <tr>
                <td><?php echo $visitor['expectedArrival']; ?></td>
                <td><?php echo $visitor['department']; ?></td>
                <td><?php echo $visitor['purpose']; ?></td>
                <td><?php echo $visitor['status']; ?></td>
                 
                </tr>
                <?php endforeach; ?>
       
        <script src="visitor_management.js"></script></body>
      </tbody>
    </table>
    <?php else: ?>
      <p style="text-align: center; text-transform: uppercase; text-rendering: optimizeSpeed; ">no appointment has been booked for today.</p>
    <?php endif; ?>

</html>
<br><br><br><br><hr><br><br><br><br>
    

            

    <h2 id="recent">HISTORY (Recent Visits)</h2>
    <?php if (!empty($recentVisitors)): ?>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>DATE</th>
            <th>OFFICE</th>
            <th>PURPOSE</th>
            <th>STATUS</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentVisitors as $visitor): ?>
            <tr>
              <td><?php echo $visitor['ArrivalDate']; ?></td>
              <td><?php echo $visitor['department']; ?></td>
              <td><?php echo $visitor['purpose']; ?></td>
              <td><?php echo $visitor['status']; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php else: ?>
      <p style="text-align: center; text-transform: uppercase; text-rendering: optimizeSpeed; ">you have no recent visits.</p>
    <?php endif; ?> 

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




