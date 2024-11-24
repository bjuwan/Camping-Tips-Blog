<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include '../includes/cookies_consent.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, email, experience_level, education, experience FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $experience_level = $_POST['experience_level'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];

    
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $filename = handle_profile_picture_upload($_FILES['profile_picture']);
    } else {
        $filename = $user['profile_picture'] ?? null; 
    }

    
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, experience_level = ?, education = ?, experience = ?, profile_picture = ? WHERE id = ?");
    $stmt->bind_param("sssssii", $name, $email, $experience_level, $education, $experience, $filename, $user_id);
    $stmt->execute();
    echo "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Outdoor Profile - Wilderness Adventures</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../assets/images/profilepage.jpg') center/cover;
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
            font-size: 3rem;
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

        form {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        select {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(44, 85, 48, 0.2);
        }

        .file-upload {
            border: 2px dashed var(--primary-color);
            padding: 2rem;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .file-upload:hover {
            background-color: rgba(44, 85, 48, 0.1);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        #file-name {
            margin-top: 1rem;
            font-style: italic;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
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
            main {
                padding: 1rem;
            }

            nav {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            nav a {
                margin: 0.5rem 0;
            }
        }

        textarea {
            width: 100%;
            min-height: 100px;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: inherit;
            resize: vertical;
        }

        textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(44, 85, 48, 0.2);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Your Outdoor Profile</h1>
            <p>Customize Your Wilderness Adventures Experience</p>
            <br><p>By creating your profile, you can share your wilderness stories, post photos from your adventures, and connect with fellow outdoor enthusiasts. You can also customize your profile to showcase your experience level, certifications, and favorite outdoor activities.</p></br>
            <br><p>If you are a new user, click the sign up button or click the sign in button to login to your account.</p></br>
            <br><p>Our platform is designed for outdoor enthusiasts who believe in responsible exploration, environmental stewardship, and the transformative power of nature. Join us to build a community that celebrates and preserves the great outdoors while inspiring others to embark on their own adventures.</p></br>
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
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Trail Name</label>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required placeholder="Your preferred outdoor nickname">
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required placeholder="Your contact email">
            </div>
            <div class="form-group">
                <label for="experience_level"><i class="fas fa-mountain"></i> Outdoor Experience</label>
                <select id="experience_level" name="experience_level" required>
                    <option value="beginner" <?php if ($user['experience_level'] == 'beginner') echo 'selected'; ?>>Beginner Explorer</option>
                    <option value="intermediate" <?php if ($user['experience_level'] == 'intermediate') echo 'selected'; ?>>Seasoned Adventurer</option>
                    <option value="expert" <?php if ($user['experience_level'] == 'expert') echo 'selected'; ?>>Wilderness Pro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="profile_picture"><i class="fas fa-camera"></i> Profile Picture</label>
                <div class="file-upload" id="drop-area">
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Drag & Drop your best outdoor photo here or click to select</p>
                    <p id="file-name"></p>
                </div>
            </div>
            <div class="form-group">
                <h3><i class="fas fa-graduation-cap"></i> Education & Experience</h3>
                <blockquote class="profile-quote">
                    Share your outdoor education and experience with the community
                </blockquote>
                
                <label for="education">Outdoor Education</label>
                <textarea id="education" name="education" placeholder="List any relevant courses, certifications, or training..."><?php echo $user['education']; ?></textarea>
                
                <label>Certifications</label>
                <ol class="certification-list">
                    <li><strong>Wilderness First Aid</strong> - <em>If applicable</em></li>
                    <li><strong>Leave No Trace</strong> - <em>If certified</em></li>
                    <li><strong>Other relevant certifications</strong></li>
                </ol>
                
                <label for="experience">Professional Experience</label>
                <textarea id="experience" name="experience" placeholder="Share your outdoor work experience..."><?php echo $user['experience']; ?></textarea>
            </div>
            <button type="submit"><i class="fas fa-save"></i> Update Your Adventure Profile</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Wilderness Adventures. All rights reserved.</p>
    </footer>
    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('profile_picture');
        const fileName = document.getElementById('file-name');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropArea.classList.add('highlight');
        }

        function unhighlight(e) {
            dropArea.classList.remove('highlight');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            updateFileName();
        }

        dropArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', updateFileName);

        function updateFileName() {
            if (fileInput.files.length > 0) {
                fileName.textContent = `Selected file: ${fileInput.files[0].name}`;
            } else {
                fileName.textContent = '';
            }
        }
    </script>
</body>
</html>

