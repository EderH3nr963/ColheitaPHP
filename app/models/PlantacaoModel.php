<?php

class PlantacaoModel {
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
    public function create($tipoPlantio, $cidade, $dataPlantio, $idUsuario, $estado, $diaIrrigacao) {
        $sql = "INSERT INTO plantacao (tipoPlantio, cidade, dataPlantio, idUsuario, estado, diaIrrigacao) VALUES (:tipoPlantio, :cidade, :dataPlantio, :idUsuario, :estado, :diaIrrigacao)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tipoPlantio', $tipoPlantio);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':dataPlantio', $dataPlantio);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':diaIrrigacao', $diaIrrigacao);
        return $stmt->execute();
    }

    // Read all
    public function readAll($idUsuario) {
        $sql = "SELECT * FROM plantacao WHERE idUsuario = :idUsuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario',$idUsuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRow($idUsuario) {
        $sql = "SELECT * FROM plantacao WHERE idUsuario = :idUsuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // Update
    public function updateEmail($nome, $email) {
        $sql = "UPDATE usuario SET nome = :nome WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function updateSenha($email, $senha) {
        $sql = "UPDATE usuario SET senha = :senha WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        return $stmt->execute();
    }

    // Delete
    public function delete($idPlantio, $idUsuario) {
        $sql = "DELETE FROM plantacao WHERE idPlantacao = :idPlantio AND idUsuario = :idUsuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idPlantio', $idPlantio);
        $stmt->bindParam(':idUsuario', $idUsuario);
        return $stmt->execute();
    }
}

