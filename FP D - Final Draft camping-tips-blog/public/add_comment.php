<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include '../includes/cookies_consent.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id']; 
    $comment_text = $_POST['comment']; 

    
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment_text, comment_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $post_id, $user_id, $comment_text);
    
    if ($stmt->execute()) {
        header("Location: post.php?id=" . $post_id); 
        exit();
    } else {
        echo "Error adding comment: " . $stmt->error; 
    }
}
?>
