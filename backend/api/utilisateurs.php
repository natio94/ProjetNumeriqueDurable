<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require 'db.php';
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET'){
    $id   = $_GET['id']   ?? null;
    $role = $_GET['role'] ?? null;

    $sql = 'SELECT id, nom, prenom, email, postal_code, role, created_at FROM utilisateurs WHERE 1=1';
    $params = [];

    if ($id) {
        $sql .= ' AND id = :id';
        $params[':id'] = $id;
    }
    if ($role) {
        $sql .= ' AND role = :role';
        $params[':role'] = $role;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll();

    echo json_encode($id ? ($users[0] ?? null) : $users);

}
else if ($method == 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;

    if ($action === 'update') {
        $sql = 'UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, postal_code = :postal_code WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':id' => $data['id'],
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email'],
            ':postal_code' => $data['postal_code'] ?? null
        ]);
        echo json_encode(['success' => $result]);

    } elseif ($action === 'delete') {
        $sql='DELETE FROM offres WHERE vendeur_id = :id';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([':id' => $data['id']]);
        $sql = 'DELETE FROM utilisateurs WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([':id' => $data['id']]);
        echo json_encode(['success' => $result]);

    } elseif ($action === 'create') {
        $sql = 'INSERT INTO utilisateurs (nom, prenom, email, postal_code, role, password) VALUES (:nom, :prenom, :email, :postal_code, :role, :password)';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email'],
            ':postal_code' => $data['postal_code'] ?? null,
            ':role' => $data['role'] ?? 'acheteur',
            ':password' => $data['password']
        ]);
        $newId = $pdo->lastInsertId();
        echo json_encode(['success' => $result, 'id' => $newId]);
    } else {
        echo json_encode(['error' => 'Action inconnue']);
    }
}
else if ($method == 'DELETE'){}
