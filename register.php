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
   
    <!-- Add your custom CSS if needed -->
    
</head>
<body>

    <div class="">
        <div class="">
            <h2 class="">Register</h2>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="">Username:</label>
                    <input type="text" name="username" class="" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="">Password:</label>
                    <input type="password" name="password" class="" required>
                </div>
                <button type="submit" class="">Register</button>
            </form>

            <a href="login.php" class="">Already have an account? Login here.</a>
        </div>
    </div>

    <!-- Add Bootstrap JS and any other dependencies if needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
