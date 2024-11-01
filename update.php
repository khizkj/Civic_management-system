<?php
include 'connect.php';

if (isset($_GET['updateid'])) {
    $userId = $_GET['updateid'];
    $stmt = $con->prepare("SELECT `username`, `email`, `password` FROM `user` WHERE `id` = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username, $email, $password);
    $stmt->fetch();
    $stmt->close();
} 


if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $con->prepare("UPDATE `user` SET `username` = ?, `email` = ?, `password` = ? WHERE `id` = ?");
    $stmt->bind_param("sssi", $username, $email, $password, $userId);

    if ($stmt->execute()) {
        header('Location: admin_panel.php'); 
        exit;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Update Account - Selecao</title>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="index-page">
  <main class="main vh-100 d-flex justify-content-center align-items-center">
    <div class="form-container">
      <h4 class="form-heading">Update Account</h4>
      <form action="update.php?updateid=<?php echo $id; ?>" method="post">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" value="<?php echo  $username ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php $email ?>" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100" name="update">Update</button>
      </form>
    </div>
  </main>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
