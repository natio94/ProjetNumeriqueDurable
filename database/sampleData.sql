use marketplace;

INSERT INTO utilisateurs (nom, prenom, email, password, postal_code, role) VALUES
('Doe', 'John', 'john.doe@gmail.com', 'password123', '75001', 'vendeur'),
('Smith', 'Jane', 'jane.smith@yahoo.com', 'pass456', '75002', 'acheteur'),
('Dupont', 'Pierre', 'pierre.dupont@outlook.com', 'secure789', '75003', 'vendeur'),
('Martin', 'Marie', 'marie.martin@gmail.com', 'motdepasse101', '75004', 'admin'),
('Dubois', 'Luc', 'luc.dubois@free.fr', 'secret202', '75005', 'vendeur'),
('Buyer', 'Alice', 'alice.buyer@gmail.com', 'buyerpass', '75006', 'acheteur');

INSERT INTO categories (name) VALUES
('Électronique'),
('Vêtements'),
('Livres'),
('Maison et Jardin'),
('Sports'),
('Alimentation');

INSERT INTO offres (vendeur_id, title, description, price, category) VALUES
(1, 'Ordinateur portable gaming', 'Ordinateur portable de jeu haute performance avec graphiques RTX', 1200.00, 1),
(1, 'Casque sans fil', 'Casque sans fil avec annulation de bruit', 150.00, 1),
(1, 'Smartphone Android', 'Téléphone intelligent Android dernière génération', 800.00, 1),
(3, 'Roman policier', 'Roman policier best-seller d\'un auteur local', 15.00, 3),
(3, 'Outils de jardinage', 'Ensemble complet d\'outils de jardinage pour débutants', 80.00, 4),
(3, 'Recette de cuisine', 'Livre de recettes de cuisine française traditionnelle', 20.00, 3),
(5, 'Panier de fruits bio', 'Panier de fruits biologiques de saison', 25.00, 6),
(5, 'Huile d\'olive extra vierge', 'Huile d\'olive extra vierge de Provence', 15.00, 6);