<?php

require 'db.php';

function executeSqlFile($pdo, $filePath) {
    $sql = file_get_contents($filePath);
    if ($sql === false) {
        die("Erreur : Impossible de lire le fichier $filePath\n");
    }
    try {
        $pdo->exec($sql);
        echo "Fichier $filePath exécuté avec succès.\n";
    } catch (PDOException $e) {
        die("Erreur lors de l'exécution de $filePath : " . $e->getMessage() . "\n");
    }
}

try {

    $pdo->exec("DROP TABLE IF EXISTS offres");
    $pdo->exec("DROP TABLE IF EXISTS categories");
    $pdo->exec("DROP TABLE IF EXISTS utilisateurs");
    echo "Tables vidées avec succès.\n";

    executeSqlFile($pdo, '../database/schema.sql');

    executeSqlFile($pdo, '../database/sampleData.sql');

    echo "Base de données initialisée avec succès !\n";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}