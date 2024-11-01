<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);  // Check if "Remember Me" is selected

    // Check if the username exists
    $stmt = $con->prepare("SELECT `id`, `password` FROM `user` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $storedPassword);
        $stmt->fetch();

        // Verify the password securely
        if (password_verify($password, $storedPassword)) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $userId;

            // Handle "Remember Me" feature
            if ($remember_me) {
                $token = bin2hex(random_bytes(16));
                $stmt->close();

                $stmt = $con->prepare("UPDATE `user` SET `remember_token` = ? WHERE `id` = ?");
                if (!$stmt) {
                    die("Preparation failed: " . $con->error);
                }

                $stmt->bind_param("si", $token, $userId);
                $stmt->execute();
                setcookie("remember_me", $token, time() + (86400 * 30), "/");
            }

            // Redirect to stored target page if available
            $redirect_to = $_SESSION['redirect_to'] ?? 'index.php';
            unset($_SESSION['redirect_to']);  // Clear the redirect session
            header("Location: $redirect_to");
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "No account found with that username.";
    }

    $stmt->close();
}

// Auto-login if "Remember Me" cookie is set and session is not
if (!isset($_SESSION['username']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $stmt = $con->prepare("SELECT `id`, `username` FROM `user` WHERE `remember_token` = ?");
    if (!$stmt) {
        die("Preparation failed: " . $con->error);
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $username);
        $stmt->fetch();

        // Set session with user data
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $userId;

        header("Location: index.php");
        exit();
    } else {
        // Clear invalid token cookie
        setcookie("remember_me", "", time() - 3600, "/");
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
        <h4 class="form-heading">Login</h4>
        <?php if (isset($login_error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $login_error; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="text-center mt-3">
                <a href="signup.php" class="link-secondary">Don't have an account? Sign Up</a>
                <a href="logout.php" class="link-secondary">Logout</a>
            </div>
        </form>
    </div>
</main>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
