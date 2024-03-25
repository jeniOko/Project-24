<?php
//Start session (if needed)
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);

if (!$isLoggedIn) {
    header("Location: ingia.php"); // Redirect to login page if not logged in
    exit;
}


// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mgeni";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$userId = $_SESSION['username'];
$ID="";
$Known="";
$address="";
$ring="";
$errorMessage = 

// Query to retrieve user's identification number
$sql = "SELECT identification,name,email,phone FROM sajili WHERE username= ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId); // Bind user ID to prevent SQL injection

// Execute query and retrieve data
if ($stmt->execute()) {
  $result = $stmt->get_result();
  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $ID = $row["identification"];
    $Known=$row["name"];
    $address=$row["email"];
    $ring=$row["phone"];
  } else {
    $errorMessage = "Identification number not found.";
  }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_SESSION["username"];
  $identification = $ID;
  $name = $_POST["name"];
  $company = $_POST["company"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $ArrivalDate = $_POST["ArrivalDate"];
  $expectedArrival= $_POST["expectedArrival"];
  $department = $_POST["department"];
  $purpose = $_POST["purpose"];
  $host = $_POST["host"];
  $vehicle = $_POST["vehicle"];

  

  // Create SQL statement
  $sql = "INSERT INTO visitors (username, identification, name, company, email, phone, ArrivalDate, expectedArrival, department, purpose, host, vehicle, date)
          VALUES ('$username','$identification', '$name', '$company', '$email', '$phone','$ArrivalDate','$expectedArrival','$department', '$purpose', '$host','$vehicle', NOW())";

  // Execute query
  if ($conn->query($sql) === TRUE) {
    echo'<script language ="javascript">';
    echo 'alert("WELCOME! \n Your appointment has been booked successfully.");';
    echo 'window.location.href = "sababu.php"';
    echo '</script>';
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  // Close connection
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitor Gatepass Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Visitor Gatepass Form</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="mb-3">
      <?php if (isset($_SESSION['username'])): ?>
      <p>Welcome, <?php echo $_SESSION['username']; ?>! 
    </p>
      
    <?php endif; ?>
      <div class="mb-3">
        <label for="identification" class="form-label">Identification card number</label>
        <input style="background-color: aliceblue ; " type="text" class="form-control" id="identification" name="identification" readonly value="<?php echo $ID; ?>" >
      </div>
        <label for="name" class="form-label">Full Name</label>
        <input style="background-color: aliceblue ; "type="text" class="form-control" id="name" name="name" placeholder="as indicated on the identification card" readonly value="<?php echo $Known; ?>">
      </div>
      <div class="mb-3">
        <label for="company" class="form-label">Company Name (if applicable)</label>
        <input type="text" class="form-control" id="company" name="company" placeholder="The organization you are representing in this visit">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input style="background-color: aliceblue ; "type="email" class="form-control" id="email" name="email" readonly value="<?php echo $address; ?>">
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input style="background-color: aliceblue ; "type="tel" class="form-control" id="phone" name="phone" readonly value="<?php echo $ring; ?>" >
      </div>
      <div class="mb-3">
        <label for="expectedArrival" class="form-label">Expected Arrival Date</label>
        <input type="date" class="form-control" id="ArrivalDate" name="ArrivalDate" required>
      </div>
      <div class="mb-3">
        <label for="expectedArrival" class="form-label">Expected Arrival Time</label>
        <input type="time" class="form-control" id="expectedArrival" name="expectedArrival" required>
      </div>

      <div class="mb-3">
        <label for="purpose" class="form-label">Purpose of Visit</label>
        <textarea class="form-control" id="purpose" name="purpose" rows="3" required></textarea>
      </div>
      <br>
      <div class="mb-3">
        <label for="department" class="form-label">Department [Select Office that you intend to visit] </label>
       <br>
          <input type="radio" name="department" value="Administration">Administration</input><br>
          <input type="radio"  name="department" value="Finance">Finance</input><br>
          <input type="radio"  name="department" value="Customer Service">Customer  Service</input><br>
          <input type="radio"  name="department" value="Registry">Registry</input>
       
      </div>
      <br>
      <div class="mb-3">
        <label for="host" class="form-label">Person You are Meeting (if applicable)</label>
        <input type="text" class="form-control" id="host" name="host">
      </div>
      <div class="mb-3">
        <label for="vehicle" class="form-label">Vehicle registration number</label>
        <input type="text" class="form-control" id="vehicle" name="vehicle" placeholder="Vehicle that you will come with" >
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
