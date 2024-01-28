<?php
require_once 'db_connect.php'; // Include the database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();

    // Redirect to login page after registration
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Simple Blog</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS if needed -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        .form-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container register-container">
        <div class="form-container">
            <h2 class="text-center mb-4">Register</h2>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <a href="login.php" class="login-link mt-3">Already have an account? Login here.</a>
        </div>
    </div>

    <!-- Add Bootstrap JS and any other dependencies if needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
