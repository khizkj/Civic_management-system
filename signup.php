<?php
include 'connect.php';

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $con->prepare("INSERT INTO `user`(`username`, `email`, `password`) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $password);

  if ($stmt->execute()) {
    header('location:login.php');

  }

  $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Civic-ms</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="index-page">
  <main class="main vh-100 d-flex justify-content-center align-items-center">
    <div class="form-container">
      <h4 class="form-heading">Create Account</h4>
      <form action="signup.php" method="post">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="submit">Sign Up</button>
        <div class="text-center mt-3">
          <a href="login.html" class="link-secondary">Already have an account? Login</a>
        </div>
      </form>
    </div>
  </main>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
