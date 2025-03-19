CREATE TABLE utente
(
    username VARCHAR(20),
    password VARCHAR(255),
    creation_timestamp TIME,
    last_login TIME,
    PRIMARY KEY(username)
);

CREATE TABLE ruoli
(
    id_ruolo VARCHAR(20),
    descrizione VARCHAR(255),
    PRIMARY KEY(id_ruolo)
);

CREATE TABLE permessi
(
    id_utente VARCHAR(20),
    id_ruolo VARCHAR(20),
    id_permesso INTEGER,
    PRIMARY KEY(id_permesso),
    CONSTRAINT FOREIGN KEY(id_utente) REFERENCES utente(username),
    CONSTRAINT FOREIGN KEY(id_ruolo) REFERENCES ruoli(id_ruolo)
);

INSERT INTO utente (username, password, creation_timestamp, last_login) 
VALUES 
('user1', 'hashedpassword1', '12:30:00', '15:45:00'),
('user2', 'hashedpassword2', '08:15:00', '11:20:00'),
('user3', 'hashedpassword3', '14:00:00', '18:30:00');

INSERT INTO ruoli (id_ruolo, descrizione) 
VALUES 
('admin', 'Administrator with full access'),
('editor', 'Can edit and manage content'),
('viewer', 'Can only view content');

INSERT INTO permessi (id_utente, id_ruolo, id_permesso) 
VALUES 
('user1', 'admin', 1),
('user2', 'editor', 2),
('user3', 'viewer', 3);
