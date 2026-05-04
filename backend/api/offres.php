<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $vendeur_id  = $_GET['vendeur_id']  ?? null;
    $categorie   = $_GET['categorie']   ?? null;
    $prix_max    = $_GET['prix_max']    ?? null;
    $prix_min    = $_GET['prix_min']    ?? null;
    $search      = $_GET['search']      ?? null;
    $id          = $_GET['id']          ?? null;

    $sql = '
    SELECT o.title,o.id, o.description, o.price,
           c.name AS categorie, 
           u.nom, u.prenom, u.email, u.postal_code
    FROM offres o
    JOIN categories c ON o.category = c.id
    JOIN utilisateurs u ON o.vendeur_id = u.id
    WHERE 1=1
';

    $params = [];

    if ($id) {
        $sql .= ' AND o.id = :id';
        $params[':id'] = $id;
    }
    if ($vendeur_id) {
        $sql .= ' AND o.vendeur_id = :vendeur_id';
        $params[':vendeur_id'] = $vendeur_id;
    }
    if ($categorie) {
        $sql .= ' AND o.category = :categorie';
        $params[':categorie'] = $categorie;
    }
    if ($prix_min) {
        $sql .= ' AND o.price >= :prix_min';
        $params[':prix_min'] = $prix_min;
    }
    if ($prix_max) {
        $sql .= ' AND o.price <= :prix_max';
        $params[':prix_max'] = $prix_max;
    }
    if ($search) {
        $sql .= ' AND (o.title LIKE :search OR o.description LIKE :search2)';
        $params[':search']  = '%' . $search . '%';
        $params[':search2'] = '%' . $search . '%';
    }

    $sql .= ' ORDER BY o.created_at DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $offres = $stmt->fetchAll();

    echo json_encode($offres);

}
else if ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;

    if ($action === 'create') {
        $sql = 'INSERT INTO offres (title, description, price, category, vendeur_id) VALUES (:title, :description, :price, :category, :vendeur_id)';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':category' => $data['category'],
            ':vendeur_id' => $data['vendeur_id']
        ]);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'delete') {
        $sql = 'DELETE FROM offres WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([':id' => $data['id']]);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'update') {
        $sql = 'UPDATE offres SET title = :title, description = :description, price = :price, category = :category WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':id' => $data['id'],
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':category' => $data['category']
        ]);
        echo json_encode(['success' => $result]);
    }

}
