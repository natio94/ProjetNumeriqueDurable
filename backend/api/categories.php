<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require 'db.php';

$stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
echo json_encode($stmt->fetchAll());
