drop database gerenciapost;
CREATE DATABASE gerenciapost;

USE gerenciapost;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('text', 'image', 'video') NOT NULL
);

CREATE TABLE textPost (
    id_post INT PRIMARY KEY,
    texto TEXT NOT NULL,
    FOREIGN KEY (id_post) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE imagePost (
    id_post INT PRIMARY KEY,
    imagem_url VARCHAR(255) NOT NULL,
    texto TEXT NULL,
    FOREIGN KEY (id_post) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE videoPost (
    id_post INT PRIMARY KEY,
    video_url VARCHAR(255) NOT NULL,
    texto TEXT NULL,
    FOREIGN KEY (id_post) REFERENCES posts(id) ON DELETE CASCADE
);
