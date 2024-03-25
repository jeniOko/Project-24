<?php

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

$errorMessage = "";
$visitors = array();

// Process form submission (if submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $startDate = filter_var($_POST["startDate"], FILTER_SANITIZE_STRING); // Sanitize start date
  $endDate = filter_var($_POST["endDate"], FILTER_SANITIZE_STRING); // Sanitize end date

  // Validate dates (optional)
  // You can add validation here to check if dates are in a valid format

  // Prepare query to retrieve visitors between dates
  $sql = "SELECT name,ArrivalDate,expectedArrival,purpose,status FROM visitors WHERE ArrivalDate BETWEEN ? AND ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $startDate, $endDate);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $visitors[] = $row;
    }
  } else {
    echo'<script language ="javascript">';
    echo 'alert("NULL!\n NO RECORDS FOUND BETWEEN THE SELECTED DATES")';
    echo '</script>';
  }

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
  <title>Visitors by Date Range</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evSXbVzTVFT4GXIr0sMG9hzEGmQlUnnQJvQ6aGyw057zWEpXGtczvWGvTVyQy0U" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-3">
    <h2>Visitors by Date Range</h2>

    <?php if (!empty($errorMessage)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php endif; ?>
    
    


<!-- <h2>Generate Visitor Report</h2> -->
    <form method="post" class="mb-3">
      <div class="row">
      <div class="col-md-6">

        <label for="startDate" >Start Date:</label>
        <input type="date" class="form-control" id="startDate" name="startDate" required>
      </div>
      <div class="col-md-6">
        <label for="endDate" >End Date:</label>
        <input type="date" class="form-control" id="endDate" name="endDate" required>
      </div>
      <button type="submit"   class="btn btn-primary">Search</button>
    </form>
    


    <?php if (!empty($visitors)): ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <?php // Display table headers based on your visitor table columns
              foreach (array_keys($visitors[0]) as $key) {
                echo "<th>" . ucfirst($key) . "</th>"; // Convert first letter to uppercase
              }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($visitors as $visitor): ?>
          <tr>
            <?php foreach ($visitor as $value): ?>
              <td><?php echo $value; ?></td>
            <?php endforeach; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      var table = document.querySelector('.table');
      table.addEventListener('click', function(e) {
        if (e.target.tagName === 'TD') {
          var row = e.target.parentNode;
          // You can access visitor data from the row here (e.g., using row.children)
          // Implement your desired action on clicking a table cell (e.g., redirect to details page)
          console.log("Clicked visitor data:", row.children); // for demonstration
        }
      });
    });
    </script>
    
  </div>
</html>
