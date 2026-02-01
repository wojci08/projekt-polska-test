-- Tworzenie bazy danych
CREATE DATABASE IF NOT EXISTS polska CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE polska;

-- Tworzenie tabeli demografia
CREATE TABLE IF NOT EXISTS demografia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rok INT NOT NULL,
    liczba_ludnosci INT NOT NULL,
    przyrost_naturalny INT NOT NULL
);

-- Tworzenie tabeli linki
CREATE TABLE IF NOT EXISTS linki (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL
);