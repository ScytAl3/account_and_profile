#------------------------------------------------------------
#                        Script MySQL.
#------------------------------------------------------------
#-- creation de la base de donnees si elle n existe pas
CREATE DATABASE IF NOT EXISTS db_account_profil_dev;
#-- on precise que l on va utiliser cette datbase pour creer les tables
USE db_account_profil_dev;

#----------------------- CREATION TABLES ASSOCIEES USERS -----------------------

#------------------------------------------------------------
# Table: users
#------------------------------------------------------------
CREATE TABLE users (
    id                  INT             NOT NULL AUTO_INCREMENT,
    lastName            VARCHAR(100)    NOT NULL,
    firstName           VARCHAR(100)    NOT NULL,
    dateOfBirth         DATE                    ,
    placeOfBirth        VARCHAR(100)            ,
    astrological_sign   VARCHAR(50)             ,
    email               VARCHAR(255)    NOT NULL UNIQUE,
    password            VARCHAR(255)    NOT NULL,
    salt                VARCHAR(255)    NOT NULL,
    presentation        TEXT                    ,
    role                VARCHAR(255)    NOT NULL DEFAULT 'ROLE_USER',
    created_at          DATETIME        NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: astrological_sign
#------------------------------------------------------------
CREATE TABLE astrological_sign (
    id              INT             NOT NULL AUTO_INCREMENT,
    sign_name       VARCHAR(50)     NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;

#-----------------------------------------------------------
#                     JEU DE DONNEES
#-----------------------------------------------------------

#-----------------------------------------------------------
# Table: USERS - Data
#-----------------------------------------------------------
INSERT INTO 
    astrological_sign(sign_name) 
VALUES
    ('Bélier'),
    ('Taureau'),
    ('Gémeaux'),
    ('Cancer'),
    ('Lion'),
    ('Vierge'),
    ('Balance'),
    ('Scorpion'),
    ('Sagittaire'),
    ('Capricorne'),
    ('Verseau'),
    ('Poissons');

#-----------------------------------------------------------
# Table: USERS - Data
#-----------------------------------------------------------

INSERT INTO 
    users(lastName, firstName, dateOfBirth, placeOfBirth, astrological_sign, email, password, salt, presentation, role, created_at) 
VALUES 
    ('Doe', 'John', null, null, null, 'j.doe@example.com', '54e4feb636204d1e5fcf49fb202946db', 'b7c8cb5b20beb2733470a65bb59722de', null, default, now()),    -- az3rty
    ( 'Jobs', 'Steve', '1955-02-24', 'San Francisco', 'Verseau', 'amazing@example.com', '1f1c153c6717024f825a862901f9c3bc', '476e62fcde5fcaa1e7fc2629da120ce9', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc omni virtuti vitium contrario nomine opponitur. Quod cum dixissent, ille contra. Summus dolor plures dies manere non potest? Sed plane dicit quod intellegit. Quamquam id quidem, infinitum est in hac urbe', default, now());  -- 4pple 
