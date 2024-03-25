

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
<body>
  <div class="container mt-5">
    <h2>Login to your account</h2>
    <form id="login-form" method="post" action="log.php">
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" id="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <br>
    <center>OR</center>
    <hr>
    <br>
   
    <a href="withOTP.php" >login with OTP</a>
  </div>

  <div class="container mt-5" id="signup">
          <h2>YOU DON'T HAVE AN EXISTING ACCOUNT?</h2>
    <p>Sign up to create an account and manage your visitor requests.</p>
    <br>
    <a href="http://localhost:3000/andikisha.php"> Register for a new account here </a>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>

      
      

   

