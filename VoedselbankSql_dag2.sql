-- ============================================================
-- Versie      : 01
-- Datum       : 09-04-2026
-- Auteur      : Voedselbank Maaskantje
-- Omschrijving: Database aanmaken voor Voedselbank Maaskantje
-- ============================================================

-- Stap 01: Database aanmaken
-- ============================================================
DROP DATABASE IF EXISTS `VoedselbankMaaskantje`;
CREATE DATABASE `VoedselbankMaaskantje`;
USE `VoedselbankMaaskantje`;

-- ============================================================
-- Stap 02: Tabel Klant aanmaken
-- ============================================================
CREATE TABLE Klant
(
     klant_id            INT             UNSIGNED    NOT NULL    AUTO_INCREMENT
    ,gezinsnaam          VARCHAR(100)                NOT NULL
    ,adres               VARCHAR(150)                NOT NULL
    ,postcode            VARCHAR(10)                 NOT NULL
    ,telefoonnummer      VARCHAR(15)                 NOT NULL
    ,email               VARCHAR(100)                NOT NULL
    ,aantal_volwassenen  INT                         NOT NULL
    ,aantal_kinderen     INT                         NOT NULL
    ,aantal_babys        INT                         NOT NULL
    ,IsActief            BIT                         NOT NULL    DEFAULT 1
    ,Opmerking           VARCHAR(255)                NULL        DEFAULT NULL
    ,CONSTRAINT PK_Klant_klant_id PRIMARY KEY CLUSTERED (klant_id)
    ,CONSTRAINT UQ_Klant_email    UNIQUE (email)
) ENGINE=InnoDB;

-- ============================================================
-- Stap 03: Testdata invoegen (minimaal 5 records)
-- ============================================================
INSERT INTO Klant (gezinsnaam, adres, postcode, telefoonnummer, email, aantal_volwassenen, aantal_kinderen, aantal_babys, IsActief, Opmerking)
VALUES
     ('De Vries',    'Dorpsstraat 12',      '5388 AB', '0612345678', 'devries@email.nl',    2, 3, 0, 1, NULL)
    ,('Janssen',     'Kerkweg 5',           '5388 CD', '0623456789', 'janssen@email.nl',    1, 2, 1, 1, 'Alleenstaande ouder')
    ,('El Amrani',   'Molenpad 8',          '5388 EF', '0634567890', 'elamrani@email.nl',   2, 1, 0, 1, NULL)
    ,('Van den Berg','Schoolstraat 33',     '5388 GH', '0645678901', 'vandenberg@email.nl', 2, 0, 0, 0, 'Inactief op eigen verzoek')
    ,('Bakker',      'Nieuweweg 17',        '5388 IJ', '0656789012', 'bakker@email.nl',     1, 4, 1, 1, NULL)
    ,('Smit',        'Lindenlaan 2',        '5388 KL', '0667890123', 'smit@email.nl',       2, 2, 0, 1, NULL)
    ,('Willems',     'Beekstraat 45',       '5388 MN', '0678901234', 'willems@email.nl',    1, 0, 0, 0, 'Geen contact meer');

-- ============================================================
-- Stap 04: Stored Procedures aanmaken
-- ============================================================
DELIMITER $$

-- Overzicht: alle klanten ophalen
CREATE PROCEDURE sp_KlantOverzicht()
BEGIN
    SELECT
         klant_id
        ,gezinsnaam
        ,adres
        ,postcode
        ,telefoonnummer
        ,email
        ,aantal_volwassenen
        ,aantal_kinderen
        ,aantal_babys
        ,IsActief
        ,Opmerking
    FROM Klant
    ORDER BY gezinsnaam ASC;
END$$

-- Klant toevoegen
CREATE PROCEDURE sp_KlantToevoegen(
     IN p_gezinsnaam         VARCHAR(100)
    ,IN p_adres              VARCHAR(150)
    ,IN p_postcode           VARCHAR(10)
    ,IN p_telefoonnummer     VARCHAR(15)
    ,IN p_email              VARCHAR(100)
    ,IN p_aantal_volwassenen INT
    ,IN p_aantal_kinderen    INT
    ,IN p_aantal_babys       INT
    ,IN p_IsActief           BIT
    ,IN p_Opmerking          VARCHAR(255)
)
BEGIN
    -- Validatie: telefoonnummer mag alleen cijfers bevatten
    IF p_telefoonnummer REGEXP '[^0-9]' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Telefoonnummer mag alleen cijfers bevatten.';
    END IF;

    -- Validatie: email moet uniek zijn
    IF EXISTS (SELECT 1 FROM Klant WHERE email = p_email) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Dit e-mailadres is al in gebruik.';
    END IF;

    INSERT INTO Klant (gezinsnaam, adres, postcode, telefoonnummer, email, aantal_volwassenen, aantal_kinderen, aantal_babys, IsActief, Opmerking)
    VALUES (p_gezinsnaam, p_adres, p_postcode, p_telefoonnummer, p_email, p_aantal_volwassenen, p_aantal_kinderen, p_aantal_babys, p_IsActief, p_Opmerking);
END$$

-- Klant wijzigen
CREATE PROCEDURE sp_KlantWijzigen(
     IN p_klant_id           INT
    ,IN p_gezinsnaam         VARCHAR(100)
    ,IN p_adres              VARCHAR(150)
    ,IN p_postcode           VARCHAR(10)
    ,IN p_telefoonnummer     VARCHAR(15)
    ,IN p_email              VARCHAR(100)
    ,IN p_aantal_volwassenen INT
    ,IN p_aantal_kinderen    INT
    ,IN p_aantal_babys       INT
    ,IN p_IsActief           BIT
    ,IN p_Opmerking          VARCHAR(255)
)
BEGIN
    -- Controleer of klant bestaat
    IF NOT EXISTS (SELECT 1 FROM Klant WHERE klant_id = p_klant_id) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Klant niet gevonden.';
    END IF;

    -- Validatie: telefoonnummer mag alleen cijfers bevatten
    IF p_telefoonnummer REGEXP '[^0-9]' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Telefoonnummer mag alleen cijfers bevatten.';
    END IF;

    -- Validatie: email moet uniek zijn (exclusief huidige klant)
    IF EXISTS (SELECT 1 FROM Klant WHERE email = p_email AND klant_id != p_klant_id) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Dit e-mailadres is al in gebruik door een andere klant.';
    END IF;

    UPDATE Klant
    SET
         gezinsnaam         = p_gezinsnaam
        ,adres              = p_adres
        ,postcode           = p_postcode
        ,telefoonnummer     = p_telefoonnummer
        ,email              = p_email
        ,aantal_volwassenen = p_aantal_volwassenen
        ,aantal_kinderen    = p_aantal_kinderen
        ,aantal_babys       = p_aantal_babys
        ,IsActief           = p_IsActief
        ,Opmerking          = p_Opmerking
    WHERE klant_id = p_klant_id;
END$$

-- Klant verwijderen
CREATE PROCEDURE sp_KlantVerwijderen(
    IN p_klant_id INT
)
BEGIN
    -- Controleer of klant bestaat
    IF NOT EXISTS (SELECT 1 FROM Klant WHERE klant_id = p_klant_id) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Klant niet gevonden.';
    END IF;

    -- Actieve klanten kunnen niet worden verwijderd
    IF EXISTS (SELECT 1 FROM Klant WHERE klant_id = p_klant_id AND IsActief = 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Actieve klanten kunnen niet worden verwijderd.';
    END IF;

    DELETE FROM Klant WHERE klant_id = p_klant_id;
END$$

DELIMITER ;
