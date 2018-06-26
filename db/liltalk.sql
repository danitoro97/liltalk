------------------------------
-- Archivo de base de datos --
------------------------------
CREATE EXTENSION pgcrypto;

--Tabla usuarios --
DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios
(
    id bigserial primary key,
    nombre varchar(255) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique,
    auth_key varchar(255) unique,
    token_val varchar(255) unique
);

INSERT INTO usuarios (nombre,password,email)
VALUES ('toro', crypt('toro',gen_salt('bf','13')),'danitoni2008@gmail.com');
