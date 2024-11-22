<?php

// --- koneksi.php ---

class Comment
{
    private ?int $id = null;
    private ?string $email = null;
    private ?string $comment = null;

    public function __construct(?int $id = null, ?string $email = null, ?string $comment = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->comment = $comment;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
}

interface CommentRepository
{
    function insert(Comment $comment): Comment;
    function findById(int $id): ?Comment;
    function findAll(): array;
}

class CommentRepositoryImpl implements CommentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    function insert(Comment $comment): Comment
    {
        $sql = "INSERT INTO comments(email, comment) VALUES (?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$comment->getEmail(), $comment->getComment()]);
        $comment->setId((int)$this->connection->lastInsertId());
        return $comment;
    }

    function findById(int $id): ?Comment
    {
        $sql = "SELECT * FROM comments WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $comment = new Comment();
                $comment->setId($row['id']);
                $comment->setEmail($row['email']);
                $comment->setComment($row['comment']);
                return $comment;
            } else {
                return null;
            }
        } catch (PDOException $exception) {
            echo "Error di findById: " . $exception->getMessage() . PHP_EOL;
            return null; // Return null jika terjadi error
        }
    }

    function findAll(): array
    {
        $sql = "SELECT * FROM comments";
        $statement = $this->connection->query($sql);

        $array = [];
        foreach ($statement as $row) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setEmail($row['email']);
            $comment->setComment($row['comment']);

            $array[] = $comment;
        }
        return $array;
    }
}

function getConnection(): PDO
{
    $host = "localhost";
    $port = 3306;
    $database = "belajar_php_database"; // Ganti dengan nama database Anda
    $username = "root"; // Ganti dengan username database Anda
    $password = ""; // Ganti dengan password database Anda

    try {
        return new PDO("mysql:host=$host:$port;dbname=$database", $username, $password);
    } catch (PDOException $exception) {
        echo "Error terkoneksi ke database : " . $exception->getMessage() . PHP_EOL;
        die(); // Hentikan eksekusi jika koneksi gagal
    }
}

// Initialize the database connection
$connection = getConnection();
?>