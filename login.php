<?php
require_once 'db_connect.php'; // Include the database connection script

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php'); // Redirect to homepage after login
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simple Blog</title>
  
  
</head>
<body>

    <div class="">
        <div class="">
            <h2 class="">Login</h2>

            <?php if (isset($error_message)) : ?>
                <div class=""><?= $error_message ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="">Username:</label>
                    <input type="text" name="username" class="" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="">Password:</label>
                    <input type="password" name="password" class="" required>
                </div>
                <button type="submit" class="">Login</button>
            </form>

            <a href="register.php" class="register-link mt-3">Don't have an account? Register here.</a>
        </div>
    </div>

    <!-- Add Bootstrap JS and any other dependencies if needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
