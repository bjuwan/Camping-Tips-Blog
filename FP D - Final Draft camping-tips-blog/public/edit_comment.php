<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';
include 'includes/cookies_consent.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $comment_id = $_POST['id'];
    $new_text = $_POST['text'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE comments SET comment_text = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $new_text, $comment_id, $user_id);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Comment updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update comment']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

