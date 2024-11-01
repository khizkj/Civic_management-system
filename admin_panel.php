<?php
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .fade-in {
      opacity: 0;
      transition: opacity 0.5s ease-in;
    }
    .fade-in.visible {
      opacity: 1;
    }
  </style>
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">Admin Panel</span>
    </div>
  </nav>

  <div class="container my-5">

    <div class="fade-in" id="users-section">
      <h3 class="mb-3">Users</h3>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Operations</th>
          </tr>
        </thead>
        <tbody>
          <?php
         $sql = "SELECT * FROM `user`";
$result = mysqli_query($con, $sql);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
    echo '<tr>
    <th scope="row">' . $id . '</th>
    <td>' . $username . '</td>
    <td>' . $email . '</td>
    <td>' . $password . '</td>
    <td>
      <button class="btn btn-dark">
        <a href="update.php?updateid='.$id.'" class="text-light" style="text-decoration: none;">Update</a>
      </button>
      <button class="btn btn-danger">
        <a href="delete.php?deleteid='.$id.'" class="text-light" style="text-decoration: none;">Delete</a>
      </button>
    </td>
    </tr>';
  }
}

            
          
          ?>



        </tbody>
      </table>
    </div>

    <div class="fade-in mt-5" id="orders-section">
      <h3 class="mb-3">Orders</h3>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col">Order ID</th>
            <th scope="col">User</th>
            <th scope="col">Product</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>101</td>
            <td>John Doe</td>
            <td>Laptop</td>
            <td>Shipped</td>
          </tr>
          <tr>
            <td>102</td>
            <td>Jane Smith</td>
            <td>Smartphone</td>
            <td>Processing</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      setTimeout(function () {
        $('.fade-in').addClass('visible');
      }, 100); 
    });
  </script>
</body>
</html>
