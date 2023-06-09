<?php

class Database
{
    public $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchUser($username) :array|bool
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user;

    }
    //Onderstaande functie doet hetzelfde als bovenstaande (verschil: maar zoekt op $id i.p.v. $username)
    public function fetchUserviaID($id) :array|bool
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user;

    }

    public function insertUser($username, $email, $passwordHash) :array
    {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $passwordHash,]);
        header('Location: /login-systeem/myaccount.php?action=create');
        exit;
    }

    public function updateUser($username, $email, $id) :array //(staat er in het vb ook bij, maar dan volgt: Uncaught TypeError: Database::updateUser(): Return value must be of type array, none returned)
    {
        $query = "UPDATE users SET username=:username, email=:email WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['username' => $username, 'email' => $email, 'id' => $id]);
        header('Location: /login-systeem/myaccount.php?action=change');
        exit;
    }

    public function updatePassword($newpasswordHash, $id) :array //(staat er in het vb ook bij)
    {
        $query = "UPDATE users SET password=:password WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['password' => $newpasswordHash, 'id' => $id]);
        header('Location: /login-systeem/myaccount.php?action=changep');
        exit;
    }
}