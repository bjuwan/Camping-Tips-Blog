<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include '../includes/cookies_consent.php';


if (!isset($_SESSION['user_id'])) {
    
    $_SESSION['redirect_message'] = "Please log in to create a post.";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];

    
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $image);

    
    $stmt = $conn->prepare("INSERT INTO posts (title, content, image, date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $content, $image);
    if ($stmt->execute()) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error creating post: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - Wilderness Adventures</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../assets/images/makepost.jpg') center/cover;
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
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .create-post-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        textarea {
            min-height: 200px;
            resize: vertical;
        }

        .file-upload {
            background: #f8f9fa;
            padding: 1.5rem;
            border: 2px dashed #ddd;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 1.5rem;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .file-upload:hover {
            border-color: var(--primary-color);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .file-upload input[type="file"] {
            display: none;
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
            <h1>Create New Adventure</h1>
            <p>Share Your Camping Experience with Our Community</p>
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
        <section class="create-post-intro">
            <h2>Share Your Adventure</h2>
            <p>Every outdoor experience is unique and valuable. Here, you can share your latest adventure with our community of nature enthusiasts. Whether it's a challenging hike, a peaceful camping trip, or an unexpected encounter with wildlife, your story can inspire and inform others.</p>
            <p>When creating your post, consider including details about the location, the duration of your trip, any gear that proved particularly useful, and tips for others who might want to follow in your footsteps. Don't forget to mention any challenges you faced and how you overcame them – these insights are incredibly valuable to fellow adventurers.</p>
            <p>Remember, the best posts are those that not only describe the beauty of the outdoors but also convey the personal growth and insights gained from the experience. So take a deep breath, recall your adventure, and start sharing!</p>
        </section>
        
        <form class="create-post-form" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Post Title</label>
                <input type="text" id="title" name="title" placeholder="Enter your post title" required>
            </div>
            
            <div class="form-group">
                <label for="content">Post Content</label>
                <textarea id="content" name="content" placeholder="Share your camping story..." required></textarea>
            </div>
            
            <label for="image">Featured Image</label>
            <div class="file-upload" onclick="document.getElementById('image').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload an image</p>
                <p class="small">(or drag and drop)</p>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            
            <button type="submit">
                <i class="fas fa-paper-plane"></i> Publish Post
            </button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Wilderness Adventures. All rights reserved.</p>
    </footer>

    <script>
        
        document.getElementById('image').addEventListener('change', function(e) {
            const fileName = e.target.files[0].name;
            const fileUpload = document.querySelector('.file-upload p');
            fileUpload.textContent = 'Selected: ' + fileName;
        });
    </script>
</body>
</html>
