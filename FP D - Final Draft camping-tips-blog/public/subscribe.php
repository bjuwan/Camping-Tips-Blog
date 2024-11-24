<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    

    $stmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error_message = "This email is already subscribed.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $success_message = "Thank you for subscribing to our newsletter!";
        } else {
            $error_message = "An error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to Our Newsletter - Wilderness Adventures</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2C5530;
            --secondary-color: #8B4513;
            --accent-color: #F4A460;
            --bg-light: #F5F5F5;
            --text-dark: #333;
            --error-color: #dc3545;
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
                        url('https://source.unsplash.com/1920x600/?camping,nature') center/cover;
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
            text-align: center;
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
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .subscribe-form {
            margin-top: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-header h2 {
            margin-bottom: 0.5rem;
        }

        .subscribe-form input[type="email"] {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .subscribe-form input[type="email"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(44, 85, 48, 0.2);
        }

        .subscribe-form button {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
        }

        .subscribe-form button:hover {
            background-color: var(--secondary-color);
        }

        .message {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            nav {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            nav a {
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Subscribe to Our Newsletter</h1>
            <p>Stay Updated with the Latest Wilderness Adventures</p>
        </div>
        <nav>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="create_post.php"><i class="fas fa-pen"></i> Create Post</a>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="signup.php"><i class="fas fa-user-plus"></i> Signup</a>
            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        </nav>
    </header>
    
    <main>
        <?php if ($success_message): ?>
            <div class="message success"><i class="fas fa-check-circle"></i> <?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="message error"><i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form class="subscribe-form" action="" method="POST">
            <div class="form-header">
                <i class="fas fa-envelope-open-text"></i>
                <h2>Join Our Community</h2>
                <p>Get weekly updates on camping tips, trail recommendations, and outdoor adventures!</p>
            </div>
            <input type="email" name="email" required placeholder="Enter your email address">
            <button type="submit"><i class="fas fa-paper-plane"></i> Subscribe</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Wilderness Adventures. All rights reserved.</p>
    </footer>
</body>
</html>
