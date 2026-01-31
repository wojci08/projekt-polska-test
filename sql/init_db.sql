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

-- Przykładowe dane
INSERT INTO demografia (rok, liczba_ludnosci, przyrost_naturalny) VALUES
(2020, 38386000, -30000),
(2021, 38325000, -40000),
(2022, 38250000, -35000);
