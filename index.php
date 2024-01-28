<?php
require_once 'db_connect.php'; // Include the database connection script

session_start();

// Check if the user is submitting a comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $comment_content = $_POST['comment_content'];

    // Insert the comment into the database
    $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $post_id, $user_id, $comment_content);
    $stmt->execute();
}

// Fetch all blog posts from the database
$sql = "SELECT posts.id, title, content, created_at, username FROM posts
        INNER JOIN users ON posts.author_id = users.id
        ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS if needed -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }

        .post {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin-top: 5px;
        }

        .timestamp {
            font-size: 12px;
            color: #888;
        }

        .comment-form {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .comment-container {
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<h1 class="mb-4">Simple Blog</h1>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <!-- <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
      <?php
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        ?>
        <a class="btn" href="create_post.php">Create Post</a>
        <a class="btn" href="logout.php">Logout</a>
        <?php
    }
    ?>
    </ul>
  </div>
</nav>




    <?php
    // Check if there are any blog posts
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
           <div class="container">
           <div class="post">
                <h2><?= $row['title'] ?></h2>
                <p><?= nl2br($row['content']) ?></p>
                <p class="timestamp">Posted by <?= $row['username'] ?> on <?= $row['created_at'] ?></p>

                <?php
                // Check if the user is logged in to show the comment form
                if (isset($_SESSION['user_id'])) {
                    ?>
                    <form method="post" class="comment-form">
                        <div class="mb-2">
                            <textarea name="comment_content" class="form-control" rows="3" placeholder="Add a comment" required></textarea>
                            <input type="hidden" name="post_id" value="<?= $row['id'] ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                    </form>
                    <?php
                }

                // Fetch and display comments for the post
                $post_id = $row['id'];
                $comment_sql = "SELECT comments.id, content, created_at, username FROM comments
                                INNER JOIN users ON comments.user_id = users.id
                                WHERE post_id = ?
                                ORDER BY created_at DESC";
                $comment_stmt = $conn->prepare($comment_sql);
                $comment_stmt->bind_param('i', $post_id);
                $comment_stmt->execute();
                $comment_result = $comment_stmt->get_result();

                if ($comment_result->num_rows > 0) {
                    ?>
                    <div class="comment-container">
                        <h5>Comments:</h5>
                        <?php
                        while ($comment = $comment_result->fetch_assoc()) {
                            ?>
                            <div class="mb-2">
                                <strong><?= $comment['username'] ?>:</strong>
                                <p><?= nl2br($comment['content']) ?></p>
                                <p class="timestamp"><?= $comment['created_at'] ?></p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
           </div>
            <?php
        }
    } else {
        echo "No blog posts yet.";
    }
    ?>

    <!-- Add Bootstrap JS and any other dependencies if needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
