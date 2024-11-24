<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_id = loginUser($email, $password);
    
    if (loginUser($email, $password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['is_admin'] = $user['is_admin']; 
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wilderness Adventures</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../assets/images/welcomeimg.jpg') center/cover;
            color: white;
            padding: 0.1rem 0rem 0rem 0rem;
            text-align: center;
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
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
            max-width: 400px;
            margin: 2rem auto;
            padding: 0 1rem;
            flex-grow: 1;
        }

        .login-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            padding-left: 2.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: var(--secondary-color);
        }

        .error {
            background-color: #fde8e8;
            color: var(--error-color);
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .signup-link {
            text-align: center;
            margin-top: 1rem;
        }

        .signup-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: auto;
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

        .info-message {
            background-color: #e7f3fe;
            border: 1px solid #b6d4fe;
            color: #084298;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Welcome</h1>
            <br><p>Log in to continue your outdoor adventure and join our community of nature enthusiasts. Whether you're a seasoned hiker, weekend camper, or just starting your outdoor journey, your experiences and insights are valuable to our growing community.</p></br>
            <br><p>As a logged-in member, you'll be able to share your wilderness stories, post photos from your adventures, and connect with fellow outdoor enthusiasts. You can also customize your profile to showcase your experience level, certifications, and favorite outdoor activities.</p></br>
            <br><p>Our platform is designed for outdoor enthusiasts who believe in responsible exploration, environmental stewardship, and the transformative power of nature. If you are a new user, click the sign up button or click the sign in button to login to your account.</p></br>
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
        <?php if (isset($error)) echo "<div class='error'><i class='fas fa-exclamation-circle'></i> $error</div>"; ?>
        <?php if (isset($_SESSION['redirect_message'])) {
            echo "<div class='info-message'><i class='fas fa-info-circle'></i> " . $_SESSION['redirect_message'] . "</div>";
            unset($_SESSION['redirect_message']); 
        } ?>
        
        <form class="login-form" action="" method="POST">
            <div class="form-header">
                <i class="fas fa-campground"></i>
                <h2>Login to Your Account</h2>
                <p>Welcome back to our community</p>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>
                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Log In
            </button>

            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up here</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Wilderness Adventures. All rights reserved.</p>
    </footer>
</body>
</html>
