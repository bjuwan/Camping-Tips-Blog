<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $post_id = $_POST['id'];
    
    
    $stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    
    if ($post && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['is_admin'])) {
        
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        
        if ($stmt->execute()) {
            
            $stmt = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'unauthorized';
    }
} else {
    echo 'invalid request';
}
