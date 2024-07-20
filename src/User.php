<?php
namespace Gem;

class User
{
    private $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function register(string $username, array $picture, string $password)
    {
        var_dump($username, $picture, $password);
        try {
            $uniqueIdentifier = uniqid();
            $targetFile = $uniqueIdentifier . '_' . str_ireplace(" ", "_", $picture['name']);
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                header("Location: register.php?error=Invalid file type");
                return;
            }

            $checkImage = getimagesize($picture["tmp_name"]);

            if ($checkImage === false) {
                header("Location: register.php?error=File is not an image");
                return;
            }


            if ($picture['size'] > 1500000) {
                header("Location: register.php?error=File is too large");
                return;
            }

            $hash_password = password_hash($password, PASSWORD_BCRYPT);


            if (move_uploaded_file($picture["tmp_name"], UPLOADDIR . $targetFile)) {
                $sql = "INSERT INTO users (username, picture, password) VALUES (:username, :picture, :password)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
                $stmt->bindValue(':picture', $targetFile, \PDO::PARAM_STR);
                $stmt->bindValue(':password', $hash_password, \PDO::PARAM_STR);
                $stmt->execute();
                header('Location: login.php');
            } else {
                header("Location: register.php?error=Sorry, there was an error uploading your file.");
            }
        } catch (\PDOException $e) {
            header('Location: register.php?error=' . $e->getMessage());
        }
    }

    public function login($username, $password)
    {
        try {
            $sql = "SELECT id, password FROM users WHERE username = :username";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();

            if (empty($result)) {
                header("Location: register.php?error=You must sign up before continuing");
            }

            $id = $result[0];
            $hash_password = $result[1];
            if (password_verify($password, $hash_password)) {
                $_SESSION['USERNAME'] = $username;
                header("Location: index.php");
            } else {
                header("Location: login.php?error=Wrong Password");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getPicture($username)
    {
        try {
            $sql = "SELECT picture FROM users WHERE username = :username";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
