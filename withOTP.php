<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
//require_once "PHPMailer/PHPMailerAutoload.php"; // Include PHPMailer library

session_start();

$errorMessage = "";
$successMessage = "";

if (isset($_POST['email'])) {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

  // Database connection (replace with your credentials)
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "mgeni";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  
  // Check if email exists (replace with your table structure)
  $sql = "SELECT * FROM sajili WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Generate random OTP
      $otp = rand(100000, 999999);
      

      
      // Store OTP in session (replace with more secure storage if needed)
      $_SESSION['otp'] = $otp;
      $_SESSION['username'] = $user['VisitorID']; // Assuming an 'id' field in the user table

      // Send OTP using PHPMailer
      $mail = new PHPMailer();

      try {
        // Server settings (configure based on your email server)
        $mail = new PHPMailer(true);
        $mail->Host = 'smtp.gmail.com';
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = 'okothjeniffer06@gmail.com';
        $mail->Password = 'nnwp azrq bcyh xgmr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('okothjeniffer06@gmail.com', 'Administrator'); 
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Login OTP';
        $mail->Body = "Your login OTP is: " . $otp;

        

        if ($mail->send()) {
          $successMessage = "OTP sent to your email address.";
        } else {
          $errorMessage = "Error sending OTP: " . $mail->ErrorInfo;
        }
      } catch (Exception $e) {
        $errorMessage = "Error sending OTP: " . $e->getMessage();
      }
    } else {
      $errorMessage = "Email not found.";
    }
  } else {
    $errorMessage = "Error checking email: " . $conn->error;
  }
  function otpUpdate($conn) {
    $otp = $_SESSION['otp'] ;
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $sql = "UPDATE sajili SET otp = '$otp' WHERE email = '$email' ";
    $result = $conn->query($sql);
    $otpUpdate= [];
    return [];
    
}
  $otpUpdate = otpUpdate($conn);

  // Close connections
  $stmt->close();
  $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login with OTP</title>
</head>
<body>
  <h2>Login</h2>
  <?php if ($errorMessage): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $errorMessage; ?>
    </div>
  <?php elseif ($successMessage): ?>
    <div class="alert alert-success" role="alert">
      <?php echo $successMessage; ?>
    </div>
  <?php endif; ?>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="mb-3">
      <label for="email">Email Address:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <button type="submit" class="btn btn-primary" onclick="otpUpdate()">Send OTP</button>
  </form>
  <?php if ($successMessage): ?>
  <p>An OTP has been sent to your email address. Please enter it below to login.</p>
  <form method="post" action="verify_otp.php"> <div class="mb-3">
      <label for="otp">OTP:</label>
      <input type="number" class="form-control" id="otp" name="otp" required>
    </div>
    <button type="submit" class="btn btn-primary">Verify OTP</button>
  </form>
<?php endif; ?>

</body>
</html>
