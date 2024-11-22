<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Komentar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1>Daftar Komentar</h1>

    <a href="form_comment.php" class="btn btn-primary mb-3">Tambah Komentar</a>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Email</th>
            <th scope="col">Komentar</th>
        </tr>
        </thead>
        <tbody>

        <?php
       require_once "koneksi.php";
        $repository = new CommentRepositoryImpl($connection);
        $comments = $repository->findAll();

        foreach ($comments as $comment) : ?>
            <tr>
                <td><?= htmlspecialchars($comment->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($comment->getEmail(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= nl2br(htmlspecialchars($comment->getComment(), ENT_QUOTES, 'UTF-8')); ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>