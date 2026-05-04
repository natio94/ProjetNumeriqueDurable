<?php

// Inclure la connexion DB
require 'api/db.php';

// Fonction pour exécuter un fichier SQL
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
    // Vider les tables (dans l'ordre inverse des dépendances)
    $pdo->exec("DROP TABLE IF EXISTS offres");
    $pdo->exec("DROP TABLE IF EXISTS categories");
    $pdo->exec("DROP TABLE IF EXISTS utilisateurs");
    echo "Tables vidées avec succès.\n";

    // Recréer les tables à partir de schema.sql
    executeSqlFile($pdo, 'schema.sql');

    // Insérer les données d'exemple à partir de sampleData.sql
    executeSqlFile($pdo, 'sampleData.sql');

    echo "Base de données initialisée avec succès !\n";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}