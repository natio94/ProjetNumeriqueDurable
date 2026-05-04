CREATE DATABASE if not exists marketplace;
use marketplace;
    create table if not exists utilisateurs (
        id INT AUTO_INCREMENT primary key,
        nom VARCHAR(255) not null,
        prenom VARCHAR(255) not null,
        email VARCHAR(255) not null,
        password VARCHAR(255) not null,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        postal_code VARCHAR(20),
        role ENUM('vendeur', 'acheteur','admin') not null DEFAULT 'acheteur'
    );
create table if not exists categories (
id INT AUTO_INCREMENT primary key,
name VARCHAR(255) not null
    );
    create table if not exists offres (
        id INT AUTO_INCREMENT primary key,
        vendeur_id INT not null,
        title VARCHAR(255) not null,
        description TEXT,
        price DECIMAL(10,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        category INT not null,
        foreign key (category) references categories(id),
        foreign key (vendeur_id) references utilisateurs(id)
    );


