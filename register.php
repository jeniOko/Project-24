<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "mgeni";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check for connection errors
if(!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Function to generate random OTP code
function generateOTP() {
  $otp = rand(100000, 999999);
  return $otp;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);


  // Validate data
  if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
    $error = "Please fill in all required fields.";
  } else if ($password !== $confirmPassword) {
    $error = "Passwords do not match.";
  } else {
    // Check if user already exists
    $sql = "SELECT COUNT(*) FROM sajili WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    //other

// Initialize variables
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate form data
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
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
    $sql = "INSERT INTO sajili (username, email, phone, password, otp, createdAt) VALUES('$username', '$email', '$phone', '$password', 'otp', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $email, $phone, $hashedPassword, $otp);
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




    if ($row['COUNT(*)'] > 0) {
      $error = "Email address already exists.";
    } else {
      // Generate and send OTP code (replace with your actual implementation)
      $otp_code = generateOTP();

      // Store user data and OTP in temporary storage (e.g., session)
      $_SESSION['otp_code'] = $otp_code;
      $_SESSION['user_data'] = [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'password' => password_hash($password, PASSWORD_DEFAULT), // Hash password before storing
        'createdAt' => date('Y-m-d H:i:s'),
      ];

      // Send OTP to user's email (replace with your actual email sending mechanism)
      // ... (e.g., using PHPMailer, SwiftMailer, etc.)

      // Change form visibility to OTP verification section
      $script = "<script>
        document.getElementById('registrationForm').style.display = 'none';
        document.getElementById('otp_verification').style.display = 'block';
      </script>";
      echo $script;
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Registration</h1>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="post" id="registrationForm">
      </form>

    <div class="mt-3" id="otp_verification" style="display: none;">
      </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>

