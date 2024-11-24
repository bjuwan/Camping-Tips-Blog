<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Wilderness Adventures</title>
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

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../assets/images/privacy-policy-header.jpg') center/cover;
            color: white;
            text-align: center;
            padding: 60px 0;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        nav {
            background-color: var(--primary-color);
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 5px;
        }

        main {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            flex-grow: 1;
        }

        h2 {
            color: var(--secondary-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
            margin-top: 30px;
        }

        p {
            margin-bottom: 20px;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Privacy Policy</h1>
        <p>Protecting Your Trail of Data</p>
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
        <p><em>Last updated: <?php echo date('F d, Y'); ?></em></p>

        <h2>1. Introduction</h2>
        <p>Welcome to Wilderness Adventures. Just as we respect the natural environment, we also respect your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>

        <h2>2. Information We Collect</h2>
        <p>Like gathering kindling for a campfire, we collect information that you provide directly to us when you register for an account, create or modify your profile, sign up for our newsletter, or communicate with us.</p>

        <h2>3. How We Use Your Information</h2>
        <p>We use the information we collect to provide, maintain, and improve our services, much like how a skilled outdoorsman uses their tools to enhance the camping experience. This includes developing new features and protecting our website and our users.</p>

        <h2>4. Cookies</h2>
        <p>We use cookies to enhance your experience on our site, similar to how a good trail mix enhances your hiking experience. You can set your browser to refuse all or some browser cookies, or to alert you when websites set or access cookies.</p>

        <h2>5. Third-Party Services</h2>
        <p>We may use third-party services to help us operate our website and provide you with a better experience, much like how we might rely on local guides to enhance our wilderness adventures.</p>

        <h2>6. Data Security</h2>
        <p>We implement measures to protect your data, just as we would protect our campsite from wildlife. However, no method of transmission over the Internet is 100% secure, so we cannot guarantee absolute security.</p>

        <h2>7. Your Rights</h2>
        <p>You have the right to access, correct, or delete your personal information, much like how you have the right to choose your own path on a hiking trail.</p>

        <h2>8. Changes to This Policy</h2>
        <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page, like leaving trail markers for other hikers.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, please contact us at privacy@wildernessadventures.com. We're always happy to help fellow adventurers navigate the terrain of data privacy!</p>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
