-- ============================================
-- CATALOGO VIDEOGIOCHI - File SQL
-- Progetto TPSIT - Istituto Tecnico Informatico
-- ============================================

-- Creazione del database
CREATE DATABASE IF NOT EXISTS videogiochi
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Selezione del database
USE videogiochi;

-- Creazione della tabella giochi
CREATE TABLE IF NOT EXISTS giochi (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titolo      VARCHAR(100)  NOT NULL,
    piattaforma VARCHAR(50)   NOT NULL,
    genere      VARCHAR(50)   NOT NULL,
    voto        INT           NOT NULL CHECK (voto >= 1 AND voto <= 10),
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- Dati di esempio per testare il progetto
INSERT INTO giochi (titolo, piattaforma, genere, voto) VALUES
('The Legend of Zelda: Breath of the Wild', 'Nintendo Switch', 'Avventura', 10),
('God of War Ragnarök',                     'PlayStation 5',  'Action RPG', 9),
('Minecraft',                               'PC',             'Sandbox',    8),
('FIFA 24',                                 'PlayStation 5',  'Sport',      7),
('Cyberpunk 2077',                          'PC',             'RPG',        8),
('Halo Infinite',                           'Xbox Series X',  'FPS',        8);
