<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require 'db.php';

$vendeur_id = $_GET['vendeur_id'] ?? null;

$sql = '
    SELECT u.nom, u.prenom, u.postal_code, u.role
    FROM utilisateurs u
    WHERE u.role=\'vendeur\'
';

if ($vendeur_id) {
    $sql .= ' AND u.id = :vendeur_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':vendeur_id' => $vendeur_id]);
} else {
    $stmt = $pdo->query($sql);
}

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));