-- 1. Create the Klant table
CREATE TABLE `Klant` (
    `klant_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `voornaam` VARCHAR(100) NOT NULL,
    `achternaam` VARCHAR(100) NOT NULL,
    `telefoonnummer` VARCHAR(15) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `aantal_volwassenen` INT DEFAULT 0 NOT NULL,
    `aantal_kinderen` INT DEFAULT 0 NOT NULL,
    `aantal_babys` INT DEFAULT 0 NOT NULL,
    `IsActief` TINYINT(1) DEFAULT 1 NOT NULL,
    `Opmerking` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Create the KlantAdres table
CREATE TABLE `KlantAdres` (
    `adres_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `klant_id` INT UNSIGNED NOT NULL,
    `straat` VARCHAR(150) NOT NULL,
    `postcode` VARCHAR(10) NOT NULL,
    `stad` VARCHAR(100) NOT NULL,
    `opmerking` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `klantadres_klant_id_foreign` 
        FOREIGN KEY (`klant_id`) REFERENCES `Klant` (`klant_id`) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Create a VIEW (The "Join" you can reuse)
-- This creates a virtual table called 'KlantOverzicht'
CREATE VIEW `KlantOverzicht` AS
SELECT 
    k.klant_id,
    k.voornaam,
    k.achternaam,
    k.email,
    a.straat,
    a.postcode,
    a.stad
FROM Klant k
LEFT JOIN KlantAdres a ON k.klant_id = a.klant_id;