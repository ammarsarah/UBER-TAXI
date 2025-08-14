CREATE DATABASE uber_taxi;

USE uber_taxi;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    tel VARCHAR(20),
    password VARCHAR(255)
);
CREATE TABLE conducteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    tel VARCHAR(20),
    password VARCHAR(255),
    permis VARCHAR(50),
    date_permis DATE
);
CREATE table admin(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    tel VARCHAR(20),
    password VARCHAR(255)
);
CREATE TABLE rides (
  id INT AUTO_INCREMENT PRIMARY KEY,
  location VARCHAR(100),
  destination VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  depart VARCHAR(100),
  arrivee VARCHAR(100),
  horaire DATETIME,
  prix DECIMAL(6,2)
);
CREATE TABLE taxis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    immatriculation VARCHAR(20) UNIQUE,
    marque VARCHAR(50),
    modele VARCHAR(50),
    annee INT,
    conducteur_id INT,
    FOREIGN KEY (conducteur_id) REFERENCES users(id)
);
CREATE TABLE reservations_taxis (
    reservation_id INT,
    taxi_id INT,
    PRIMARY KEY (reservation_id, taxi_id),
    FOREIGN KEY (reservation_id) REFERENCES reservations(id),
    FOREIGN KEY (taxi_id) REFERENCES taxis(id)
);
CREATE TABLE trajets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    depart VARCHAR(100),
    arrivee VARCHAR(100),
    distance DECIMAL(5,2),
    duree INT,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);
CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    note INT CHECK (note >= 1 AND note <= 5),
    commentaire TEXT,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);
CREATE TABLE promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    description TEXT,
    reduction DECIMAL(5,2),
    date_debut DATE,
    date_fin DATE
);
CREATE TABLE factures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    montant DECIMAL(6,2),
    date_emission DATETIME,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);
CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    facture_id INT,
    montant DECIMAL(6,2),
    date_paiement DATETIME,
    mode VARCHAR(50),
    statut VARCHAR(50),
    FOREIGN KEY (facture_id) REFERENCES factures(id)
);
CREATE TABLE alertes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT,
    date DATETIME,
    lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    content TEXT,
    date DATETIME,
    lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
)
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT,
    date DATETIME,
    lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE historiques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255),
    date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE parametres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) UNIQUE,
    valeur VARCHAR(255)
);