<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';


$posts = getAllPosts();


if (empty($posts)) {
    $default_posts = [
        [
            'title' => 'Welcome to Wilderness Adventures',
            'content' => 'Embark on a journey through nature\'s wonders with Wilderness Adventures. Discover hidden trails, breathtaking vistas, and unforgettable experiences in the great outdoors.',
            'image' => 'default_post_1.jpg',
            'date' => date('Y-m-d H:i:s'),
            'author_name' => 'Admin'
        ],
        [
            'title' => 'Essential Camping Gear for Beginners',
            'content' => 'Planning your first camping trip? Don\'t forget these essential items: a sturdy tent, sleeping bag, portable stove, and water filtration system. Being prepared ensures a safe and enjoyable adventure.',
            'image' => 'default_post_2.jpg',
            'date' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'author_name' => 'Admin'
        ],
        [
            'title' => 'Top 5 Hiking Trails in North America',
            'content' => 'Explore some of the most scenic hiking trails in North America, from the rugged Appalachian Trail to the majestic Pacific Crest Trail. Each offers unique challenges and breathtaking views.',
            'image' => 'default_post_3.jpg',
            'date' => date('Y-m-d H:i:s', strtotime('-2 days')),
            'author_name' => 'Admin'
        ]
    ];
    
    $posts = $default_posts;

    
    foreach ($default_posts as $post) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content, image, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $post['title'], $post['content'], $post['image'], $post['date']);
        $stmt->execute();
    }
}

$cookie_consent = $_COOKIE['cookie_consent'] ?? null;

if ($cookie_consent === 'accepted') {
    
} else {
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wilderness Adventures - Camping Blog</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../assets/images/index.jpg') center/cover;
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

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 2rem;
        }

        .posts {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .post {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .post:hover {
            transform: translateY(-5px);
        }

        .post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-content {
            padding: 1.5rem;
        }

        .post h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .post h2 a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .post-date {
            color: #666;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .sidebar {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .newsletter {
            margin-top: 1rem;
        }

        .newsletter input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .newsletter button {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .newsletter button:hover {
            background-color: var(--accent-color);
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
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

        #cookie-consent-mini {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            background-color: #f1f1f1;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-size: 14px;
            z-index: 1000;
        }

        #cookie-consent-mini p {
            margin: 0 0 10px 0;
        }

        .cookie-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        #cookie-consent-mini button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #accept-cookies {
            background-color: #4CAF50;
            color: white;
        }

        #decline-cookies {
            background-color: #f44336;
            color: white;
        }

        #cookie-consent-mini a {
            color: #2C5530;
            text-decoration: none;
            font-size: 12px;
        }

        #cookie-consent-mini a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Wilderness Adventures</h1>
            <p>Discover the Art of Outdoor Living</p>
        </div>
        <nav>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="create_post.php"><i class="fas fa-pen"></i> Create Post</a>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="signup.php"><i class="fas fa-user-plus"></i> Signup</a>
            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
            <a href="resume.html"><i class="fas fa-file-alt"></i> Resume</a>
            <a href="index.html"><i class="fas fa-home"></i> Website Info - Index.html </a>
        </nav>
    </header>
    
    <main>
        <div class="container welcome-container">
            <section class="welcome">
                <h2>Welcome to Wilderness Adventures</h2>
                <div class="welcome-content">
                    <p>Embark on a journey through nature's wonders with Wilderness Adventures. Our platform is dedicated to bringing outdoor enthusiasts together, sharing experiences, and inspiring new adventures in the great outdoors.</p>
                    <p>Whether you're a seasoned hiker, a camping novice, or simply someone who appreciates the beauty of nature, you'll find a wealth of information and a community of like-minded individuals here. Our blog posts cover everything from trail recommendations and gear reviews to survival tips and conservation efforts.</p>
                    <p>Join our community today to share your own experiences, learn from others, and discover your next great adventure. The wilderness is calling – are you ready to answer?</p>
                </div>
            </section>
        </div>
        
        <div class="container">
            <div class="posts">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <img src="../assets/images/<?php echo htmlspecialchars($post['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? ''); ?>">
                        <div class="post-content">
                            <h2>
                                <?php if (isset($post['id'])): ?>
                                    <a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title'] ?? ''); ?></a>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($post['title'] ?? ''); ?>
                                <?php endif; ?>
                            </h2>
                            <p><?php echo substr(htmlspecialchars($post['content'] ?? ''), 0, 150); ?>...</p>
                            <p class="post-meta">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($post['author_name'] ?? 'Anonymous'); ?> | 
                                <i class="far fa-calendar-alt"></i> <?php echo isset($post['date']) ? date('F j, Y', strtotime($post['date'])) : 'Unknown Date'; ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <aside class="sidebar">
                <h2>Join Our Community</h2>
                <div class="newsletter">
                    <form action="subscribe.php" method="POST">
                        <input type="email" name="email" required placeholder= "Enter your email"> 
                        <button type="submit"><i class="far fa-paper-plane"></i> <strong>Subscribe</strong></button>
                    </form>
                </div>
            </aside>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
