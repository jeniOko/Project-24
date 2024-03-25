
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mgeni";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate form data
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $identification = filter_input(INPUT_POST, 'identification', FILTER_SANITIZE_STRING);
  $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

  // Validate password match
  if ($password !== $confirmPassword) {
    $error = "Passwords do not match.";
    return;
  }

  // Generate a random OTP (replace with your preferred method)
  $otp = rand(100000, 999999);

  // Hash the password before storing it
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  // Attempt to insert data into the database
  try {
    $sql = "INSERT INTO sajili (username,name,identification, email, phone, gender, password, otp, createdAt) VALUES(?, ?, ?, ?, ?,?,?,?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $username,$name,$identification,$email,$phone, $gender,$password, $otp);
    $stmt->execute();

    // Send OTP to the user's email (replace with your preferred method)
    // ... (e.g., using a mailing service or API)

    // Display success message and show OTP verification section
    $success = "Registration successful! Please check your email for the OTP code to verify your account.";
    echo "<script>document.getElementById('otp_verification').style.display = 'block';</script>";
  } catch (Exception $e) {
    $error = "An error occurred during registration: " . $e->getMessage();
  }
}

/*
$error = "";
$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

  
  if ($confirmPassword != $password) {
    echo'<script language ="javascript">';
    echo 'alert("SIGNUP ERROR! \n Your password does not match.");';
    echo 'window.location.href = "andikisha.php"';
    echo '</script>';
  }
  else{
    echo'<script language ="javascript">';
    echo 'alert("SIGNUP SUCCESS! \n Your registration is successfully!");';
    echo 'window.location.href = "ingia.php"';
    echo '</script>';

  }

  
  $otp = rand(100000, 999999);// Generate a random OTP
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  $sql = "INSERT INTO sajili (username,name,identification, email, phone, gender, password, otp, createdAt) VALUES('$username','$name','$identification', '$email', '$phone','$gender', '$password', 'otp', NOW())";  
  
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
  
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
  body{
    background-image: url('IMG signup.jpg');
    background-size: cover; 
    background-position: center;

  }
  .container {
    width: 700px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: aliceblue;
  }
    

   </style>
</head>
<body >
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Visitors Management System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <a class="nav-link" href="http://localhost:3000/wasili.html">Home</a>
          <a class="nav-link" href="http://localhost:3000/ingia.php">Login</a>
          <a class="nav-link" href="#inquire">Inquire</a>
          <a class="nav-link" href="#about">About</a>
        </div>
      </div>
    </div>
  </nav>
  
  
  <div class="container mt-5">
    <h1>Join our community today</h1>
    <form method="post" id="myForm" onsubmit="return myFunction()" > 
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="as indicated on the identification card" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Identification Number</label>
        <input type="text" class="form-control" id="identification" name="identification" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phone" name="phone">
      </div>
      <div class="mb-3">
        <label for="gender">Gender:</label><br>
        <input type="radio" name="gender" id="gender" value="male"> Male<br>
        <input type="radio" name="gender" id="gender" value="female"> Female<br>
        <input type="radio" name="gender" id="gender" value="Unspecified"> Prefer not to say
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="select a simple name to be used for loging in">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>
      <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
      </div>
    </form>

    <div class="mt-3" id="otp_verification" style="display: none;">
      <h2>OTP Verification</h2>
      <p>An OTP has been sent to your email address. Please enter the code below to verify your account.</p>
      <input type="text" class="form-control mb-3" id="otp_code">
      <button type="button" class="btn btn-primary" id="verifyBtn">Verify</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script >
  const submitBtn = document.getElementById('submitBtn');
const otpVerification = document.getElementById('otp_verification');
const verifyBtn = document.getElementById('verifyBtn');
const successMessage = document.getElementById('successMessage'); // Assuming an element with this ID exists

submitBtn.addEventListener('click', function(event) {
  event.preventDefault(); // Prevent default form submission

  // Client-side validation (optional)
  if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
    alert('Passwords do not match!');
    return;
  }

  // Gather form data
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const name = document.getElementById('name').value;
  const identification = document.getElementById('identification').value;
  const gender = document.getElementById('gender').value;
  const phone = document.getElementById('phone').value;
  const password = document.getElementById('password').value;

  // Send registration data to server using AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'andikisha.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  const formData = new FormData();
  formData.append('username', username);
  formData.append('email', email);
  formData.append('phone', phone);
  formData.append('password', password);

  xhr.onload = function() {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        // Display success message and show OTP verification section
        successMessage.textContent = response.success;
        otpVerification.style.display = 'block';

        // Clear form fields after successful submission
        document.getElementById('registrationForm').reset();

        // Disable submit button to prevent resubmission (optional)
        submitBtn.disabled = true;
      } else {
        alert(response.error); // Display any error message received from server
      }
    } else {
      alert('An error occurred during registration. Please try again later.');
    }
  };

  xhr.onerror = function() {
    alert('Failed to send registration data. Please check your internet connection and try again.');
  };

  xhr.send(formData);
});

verifyBtn.addEventListener('click', function() {
  // Implement logic to send OTP verification code to server (replace with your actual implementation)
  // ... (e.g., using fetch API or form submission)
});


 </script>
 

 </script>
 </html>
