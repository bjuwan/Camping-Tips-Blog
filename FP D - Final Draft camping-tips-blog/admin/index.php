<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}


$posts = getAllPosts(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Manage Posts</h2>
    <a href="create_post.php">Create New Post</a>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <?php echo $post['title']; ?>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
                <a href="delete_post.php?id=<?php echo $post['id']; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

