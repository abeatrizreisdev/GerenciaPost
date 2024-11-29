drop database gerenciapost;
CREATE DATABASE gerenciapost;

USE gerenciapost;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('text', 'image', 'video') NOT NULL
);

CREATE TABLE textPost (
    id INT PRIMARY KEY,
    texto TEXT NOT NULL,
    FOREIGN KEY (id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE imagePost (
    id INT PRIMARY KEY,
    imagem_url VARCHAR(255) NOT NULL,
    texto TEXT NULL,
    FOREIGN KEY (id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE videoPost (
    id INT PRIMARY KEY,
    video_url VARCHAR(255) NOT NULL,
    texto TEXT NULL,
    FOREIGN KEY (id) REFERENCES posts(id) ON DELETE CASCADE
);