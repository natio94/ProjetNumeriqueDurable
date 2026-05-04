<?php
try {
    $pdo = new PDO(
        'mysql:host=' . getenv('MYSQLHOST') .
        ';port='      . getenv('MYSQLPORT') .
        ';dbname='    . getenv('MYSQLDATABASE') .
        ';charset=utf8',
        getenv('MYSQLUSER'),
        getenv('MYSQLPASSWORD')
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Connexion DB échouée : ' . $e->getMessage()]);
    exit;
}
