-- Step: 01
-- *********************************************************
-- Doel : Maak een nieuwe databaseweergave voor Products
-- *********************************************************
--
-- Versie     Datum        Auteur          Omschrijving
-- 01         09-04-2026   GitHub Copilot  Products
-- *********************************************************

-- Verwijder tabel products
DROP TABLE IF EXISTS products;

-- Step: 02
-- *********************************************************
-- Doel : Maak een nieuwe tabel aan met de naam Products
-- *********************************************************
--
-- Versie     Datum        Auteur          Omschrijving
-- 01         09-04-2026   GitHub Copilot  Tabel Products
-- *********************************************************
-- Onderstaande velden toevoegen aan de tabel Products
-- Id, Barcode, Name, Category, Stock, Is_used_in_food_package,
-- Created_at, Updated_at
-- *********************************************************

CREATE TABLE products
(
    id                      INTEGER        NOT NULL PRIMARY KEY AUTOINCREMENT,
    barcode                 VARCHAR(255)   NOT NULL,
    name                    VARCHAR(255)   NOT NULL,
    category                VARCHAR(255)   NOT NULL,
    stock                   INTEGER        NOT NULL,
    is_used_in_food_package TINYINT(1)     NOT NULL DEFAULT 0,
    created_at              DATETIME                DEFAULT NULL,
    updated_at              DATETIME                DEFAULT NULL
);

CREATE UNIQUE INDEX products_barcode_unique
    ON products (barcode);

-- Step: 03
-- *********************************************************
-- Doel : Voeg voorbeelddata toe aan de tabel Products
-- *********************************************************

INSERT INTO products
(
    barcode,
    name,
    category,
    stock,
    is_used_in_food_    '3421',
    'Magazijnw',
    'wew',
    23,
    0,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
)
;05,
    0,0
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);
STAMP
);
