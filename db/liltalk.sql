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
    token_val varchar(255) unique,
    biografia text,
    zona_horaria varchar(255) default 'Europe/Madrid'
);

INSERT INTO usuarios (nombre,password,email)
VALUES ('toro', crypt('toro',gen_salt('bf','13')),'danitoni2008@gmail.com'),
       ('juan', crypt('juan',gen_salt('bf','13')),'danitoni2007@gmail.com'),
       ('javi', crypt('javi',gen_salt('bf','13')),'danitoni2009@gmail.com');


---- Tabla Categorias ---
DROP TABLE IF EXISTS categorias cascade;
CREATE TABLE categorias
(
    id bigserial primary key,
    nombre varchar(255) not null unique
);

INSERT INTO categorias (nombre)
VALUES ('Musica'),('Ciencia'),('Politica'),('Otros');

-- Tabla Salas ---
DROP TABLE IF EXISTS  salas CASCADE;
CREATE TABLE salas
(
    id bigserial primary key,
    nombre varchar(255) not null unique,
    creador_id bigint not null references usuarios(id)
                                        on delete CASCADE
                                        on update CASCADE,
    descripcion text,
    categoria_id bigint not null references categorias (id)
                                    on delete CASCADE
                                    on update cascade,
    numero_participantes numeric(2) not null,
    privada boolean default false,
    created_at timestamp default current_timestamp
);

INSERT INTO  salas (nombre,creador_id,descripcion,categoria_id,numero_participantes)
VALUES ('Primera sala',1,'Sala de prueba',1,2);

-- Tabla participantes --
DROP TABLE IF EXISTS participantes CASCADE;
CREATE TABLE participantes
(
    id bigserial primary key,
    usuario_id bigint not null references usuarios(id)
                                        on delete CASCADE
                                        on update CASCADE,
    sala_id bigint not null references salas(id)
                                        on delete CASCADE
                                        on update CASCADE,
    color varchar(7),
    CONSTRAINT uq_sala_usuario UNIQUE (usuario_id,sala_id)
);

INSERT INTO participantes (usuario_id,sala_id,color)
VALUES (1,1,'#aabbcc'),(2,1,'#ff0000');

--Vista salas disponibles --
CREATE VIEW salas_disponibles as
    SELECT sala_id,nombre,descripcion,categoria_id,numero_participantes,salas.id,creador_id
    FROM salas
    		LEFT JOIN participantes p ON salas.id = p.sala_id
    WHERE privada = FALSE
    GROUP BY sala_id,numero_participantes,nombre,descripcion,categoria_id,salas.id,creador_id
    HAVING numero_participantes > count(*)
    ORDER BY created_at DESC;


-- Triggers --

CREATE OR REPLACE FUNCTION anadir_participante() RETURNS trigger AS $$
        BEGIN
                perform from salas
				where id = NEW.sala_id and numero_participantes > (select count(*) from participantes
														where sala_id = NEW.sala_id);

				if not found then
					raise exception 'Sala llena';
				end if;
				return NEW;
        END;
$$ LANGUAGE plpgsql;

--Trigger que comproba si la sala esta disponible o no --

DROP TRIGGER IF EXISTS anadir_participante on participantes CASCADE;
CREATE TRIGGER anadir_participante
BEFORE INSERT OR UPDATE on participantes
FOR EACH ROW
EXECUTE PROCEDURE anadir_participante();

-- Tabla mensajes --
DROP TABLE IF EXISTS mensajes CASCADE;
CREATE TABLE mensajes
(
    id bigserial primary key,
    usuario_id bigint not null references usuarios(id)
                                        on delete CASCADE
                                        on update CASCADE,
    sala_id bigint not null references salas(id)
                                        on delete CASCADE
                                        on update CASCADE,
    mensaje text not null,
    created_at TIMESTAMP WITH TIME ZONE ,
    updated_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO mensajes (sala_id,usuario_id,mensaje)
VALUES (1,1,'Primer mensaje');
