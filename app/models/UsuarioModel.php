<?php

class UsuarioModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=colheitaphp", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Create
    public function create($nome, $email, $senha) {
        $sql = "INSERT INTO usuario (nome, email, senha, emailAuthenticate) VALUES (:nome, :email, :senha, false)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        return $stmt->execute();
    }

    // Read all
    public function readAll() {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read one
    public function read($email) {
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRow($email) {
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // Update
    public function updateSenha($email, $senha) {
        $sql = "UPDATE usuario SET senha = :senha WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        return $stmt->execute();
    }

    public function updateAuthenticateEmail($authEmail, $email) {
        $sql = "UPDATE usuario SET emailAuthenticate = :authEmail WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':authEmail', $authEmail);
        return $stmt->execute();
    }

    // Delete
    public function delete($email) {
        $sql = "DELETE FROM usuario WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}

