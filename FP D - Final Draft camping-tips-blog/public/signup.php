<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $experience_level = $_POST['experience_level'];
    
    
    $is_email = filter_var($username, FILTER_VALIDATE_EMAIL);
    
    if ($is_email) {
        $email = $username;
        $username = explode('@', $email)[0]; 
    } else {
        $email = null;
    }
    
    if (registerUser($name, $username, $email, $password, $experience_level)) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Wilderness Adventures - Sign Up</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../assets/images/welcomeimg.jpg') center/cover;
            color: white;
            padding: 2rem 0;
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
            max-width: 500px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .signup-form {
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

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
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

        input,
        select {
            width: 100%;
            padding: 0.8rem;
            padding-left: 2.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M8 11l-7-7h14l-7 7z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        .experience-icons {
            display: flex;
            justify-content: space-around;
            margin: 1rem 0;
            text-align: center;
        }

        .experience-level {
            color: #666;
            font-size: 0.9rem;
        }

        .experience-level i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
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

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            background-color: #fde8e8;
            color: var(--error-color);
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
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
            <h1>Join Our Adventure</h1>
            <br><p>Join our community of outdoor enthusiasts and start your journey to explore the wilderness.</p></br>
            <br><p>Create your account to start sharing your adventures and connecting with fellow outdoor enthusiasts.</p></br>
            <br><p>Choose your experience level to help us match you with the right adventures and adjust your experience level with others users as well.</p></br>
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
        
        <form class="signup-form" action="" method="POST">
            <div class="form-header">
                <i class="fas fa-campground"></i>
                <h2>Create Your Account</h2>
                <p>Join our community of outdoor enthusiasts</p>
            </div>

            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Trail Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="username"><i class="fas fa-at"></i> Username or Email</label>
                <input type="text" id="username" name="username" required>
                <small>Enter either a username or email address</small>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="experience_level"><i class="fas fa-mountain"></i> Experience Level</label>
                <select id="experience_level" name="experience_level" required>
                    <option value="beginner">Beginner Explorer</option>
                    <option value="intermediate">Seasoned Adventurer</option>
                    <option value="expert">Wilderness Pro</option>
                </select>
            </div>

            <button type="submit"><i class="fas fa-sign-in-alt"></i> Create Account</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Wilderness Adventures. All rights reserved.</p>
    </footer>
</body>
</html>