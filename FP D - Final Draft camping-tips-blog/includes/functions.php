<?php
include 'db_connect.php';


function registerUser($name, $username, $email, $password, $experience_level) {
    global $conn;
    
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return false;
    }
    
    
    if ($email !== null) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return false;
        }
    }
    
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    
    $stmt = $conn->prepare("INSERT INTO users (name, username, email, password, experience_level) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $email, $hashed_password, $experience_level);
    
    return $stmt->execute();
}


function loginUser($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            return $id; 
        }
    }
    return false; 
}


function getAllPosts() {
    global $conn;
    $stmt = $conn->prepare("SELECT p.*, u.name as author_name FROM posts p LEFT JOIN users u ON p.user_id = u.id ORDER BY p.date DESC");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


function getPostById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function addComment($post_id, $user_id, $comment, $parent_id = null) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment, date, parent_id) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("iisi", $post_id, $user_id, $comment, $parent_id);
    return $stmt->execute();
}


function subscribeToNewsletter($email) {
    global $conn;

    
    $stmt = $conn->prepare("SELECT * FROM newsletter_subscriptions WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        

    } else {
        
        $stmt = $conn->prepare("INSERT INTO newsletter_subscriptions (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        return $stmt->execute(); 
    }
}


function getCommentsByPostId($post_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT c.*, u.name as user_name FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.comment_date DESC");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
