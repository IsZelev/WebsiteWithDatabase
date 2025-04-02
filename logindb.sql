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
    FOREIGN KEY(id_utente) REFERENCES utente(username),
    FOREIGN KEY(id_ruolo) REFERENCES ruoli(id_ruolo)
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

CREATE TABLE Cliente
(
    id_cliente VARCHAR(5),
    nome VARCHAR(25),
    cognome VARCHAR(25),
    data_prenotazione DATE,
    PRIMARY KEY(id_cliente)
);

CREATE TABLE Sala
(
    id_sala VARCHAR(5),
    nome VARCHAR(25),
    capienza INT,
    PRIMARY KEY(id_sala)
);

CREATE TABLE Spettacolo
(
    id_spettacolo VARCHAR(5),
    titolo VARCHAR(25),
    trama VARCHAR(500),
    data_inizio DATETIME,
    data_fine DATETIME,
    PRIMARY KEY(id_spettacolo)
);

CREATE TABLE Trama
(
    id_trama VARCHAR(5),
    nome VARCHAR(25),
    descrizione VARCHAR(500),
    PRIMARY KEY(id_trama)
);

CREATE TABLE Prenotazione
(
    id_prenotazione VARCHAR(5),
    id_cliente VARCHAR(5),
    id_proiezione VARCHAR(5),
    costo FLOAT,
    data_prenotazione DATE,
    numero_biglietti INT,
    PRIMARY KEY(id_prenotazione),
    FOREIGN KEY(id_cliente) REFERENCES Cliente(id_cliente),
    FOREIGN KEY(id_proiezione) REFERENCES Proiezione(id_proiezione)
);

CREATE TABLE Proiezione
(
    id_proiezione VARCHAR(5),
    orario TIME,
    id_sala VARCHAR(5),
    id_spettacolo VARCHAR(5),
    PRIMARY KEY(id_proiezione),
    FOREIGN KEY(id_sala) REFERENCES Sala(id_sala),
    FOREIGN KEY(id_spettacolo) REFERENCES Spettacolo(id_spettacolo)
);

CREATE TABLE Argomenti
(
    id_argomenti VARCHAR(5),
    id_spettacolo VARCHAR(5),
    id_trama VARCHAR(5),
    PRIMARY KEY(id_argomenti),
    FOREIGN KEY(id_spettacolo) REFERENCES Spettacolo(id_spettacolo),
    FOREIGN KEY(id_trama) REFERENCES Trama(id_trama)
);