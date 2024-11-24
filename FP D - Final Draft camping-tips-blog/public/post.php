<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include '../includes/cookies_consent.php';


$post_id = $_GET['id'] ?? 0;


$stmt = $conn->prepare("SELECT p.*, u.name as author_name FROM posts p LEFT JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();


if (!$post) {
    
    die("Post not found");
}


$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$canDelete = isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || $isAdmin);


$comments = getCommentsByPostId($post_id);


function isCommentAuthor($comment_user_id) {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment_user_id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Wilderness Adventures</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2C5530;
            --secondary-color: #8B4513;
            --accent-color: #F4A460;
            --bg-light: #F5F5F5;
            --text-dark: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('../assets/images/<?php echo $post['image']; ?>') center/cover;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        nav {
            background-color: var(--primary-color);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        main {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .post-content {
            font-family: 'Lora', serif;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .post-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .comment-section {
            margin-top: 3rem;
            border-top: 1px solid #ddd;
            padding-top: 2rem;
        }

        .comment-form textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .comment-form button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .comment-form button:hover {
            background-color: var(--secondary-color);
        }

        .comment-list {
            list-style-type: none;
        }

        .comment {
            background-color: #f9f9f9;
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .comment-meta {
            font-size: 0.8rem;
            color: #666;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            main {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <p>Discover the Art of Outdoor Living</p>
        </div>
    </header>
    <nav>
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="create_post.php"><i class="fas fa-pen"></i> Create Post</a>
        <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        <a href="signup.php"><i class="fas fa-user-plus"></i> Signup</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="resume.html"><i class="fas fa-file-alt"></i> Resume</a>
    </nav>
    <main>
        <article class="post">
            <h1><?php echo htmlspecialchars($post['title'] ?? ''); ?></h1>
            <p class="post-meta">
                <i class="fas fa-user"></i> <?php echo htmlspecialchars($post['author_name'] ?? 'Unknown Author'); ?> | 
                <i class="far fa-calendar-alt"></i> <?php echo isset($post['date']) ? date('F j, Y', strtotime($post['date'])) : 'Unknown Date'; ?>
            </p>
            <div class="post-content">
                <?php echo nl2br(htmlspecialchars($post['content'] ?? '')); ?>
            </div>
            <?php if ($canDelete): ?>
                <button id="deletePost" class="btn btn-danger">Delete Post</button>
            <?php endif; ?>
        </article>
        <section class="comment-section">
            <h2><i class="fas fa-comments"></i> Comments</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="add_comment.php" method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <textarea name="comment" required placeholder="Share your thoughts..."></textarea>
                    <button type="submit"><i class="fas fa-paper-plane"></i> Add a Comment</button>
                </form>
            <?php else: ?>
                <p>Please <a href="login.php">login</a> to leave a comment.</p>
            <?php endif; ?>
            <ul class="comment-list">
                <?php foreach ($comments as $comment): ?>
                    <li class="comment" id="comment-<?php echo $comment['id']; ?>">
                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                        <p class="comment-meta">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($comment['user_name']); ?> | 
                            <i class="far fa-clock"></i> <?php echo date('F j, Y g:i a', strtotime($comment['comment_date'])); ?>
                            <?php if (isCommentAuthor($comment['user_id'])): ?>
                                | <a href="#" class="edit-comment" data-id="<?php echo $comment['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                | <a href="#" class="delete-comment" data-id="<?php echo $comment['id']; ?>"><i class="fas fa-trash"></i> Delete</a>
                            <?php endif; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
