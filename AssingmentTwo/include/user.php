<?php

class user
{
private PDO $db;
public function __construct(PDO $dbConnection){
    $this->db = $dbConnection;
}

public function register(string $username,string $email, string $password):bool {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email
    ]);
    if ($stmt->fetchColumn() > 0) {
        return false;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    return $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $passwordHash
    ]);
}

public function login(string $usernameOrEmail, string $password) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :ue OR email = :ue LIMIT 1");
    $stmt->execute([':ue' => $usernameOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}


}