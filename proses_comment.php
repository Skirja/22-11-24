<?php
require_once "koneksi.php"; // File koneksi database (lihat di bawah)

// Sanitize and validate input
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$commentText = htmlspecialchars(trim($_POST['comment'] ?? ''), ENT_QUOTES, 'UTF-8');

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Email tidak valid!'); window.location.href='form_comment.php';</script>";
    exit;
}

// Validate comment
if (empty($commentText)) {
    echo "<script>alert('Komentar tidak boleh kosong!'); window.location.href='form_comment.php';</script>";
    exit;
}

try {
    $comment = new Comment(email: $email, comment: $commentText);
    $repository = new CommentRepositoryImpl($connection);
    $newComment = $repository->insert($comment);

    echo "<script>alert('Komentar berhasil ditambahkan.'); window.location.href='view_comments.php';</script>";

} catch (PDOException $exception) {
    echo "<script>alert('Error: " . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . "'); window.location.href = 'form_comment.php'</script>";
}
?>