<?php
class UserStorage
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUser($username, $email, $password)
    {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ":role" => "user"
        ]);
        $id = $this->pdo->lastInsertId();

        return $id;
    }

    // get all
    public function getAll()
    {
        $sql = "SELECT id, username, email, role FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $sql = "SELECT id, username, email, password, role FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT id, username, email, role, password FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $username, $email)
    {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':id' => $id
        ]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
