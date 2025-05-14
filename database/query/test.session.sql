create table utenti(
    id int primary key AUTO_INCREMENT,
    name varchar(200) not null,
    surname varchar(200) not null,
    username varchar(200) not null UNIQUE,
    email varchar(200) not null UNIQUE,
    password varchar(255) not null,
    ruolo varchar(20) DEFAULT 'utente',
    ultimo_login DATETIME,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    avatar varchar(200) DEFAULT null
);

--@block
create table ruoli(
    id int AUTO_INCREMENT primary key,
    nome varchar(40) not null,
    descrizione TEXT
);

--@block
insert into ruoli(nome, descrizione)
values("utente", "Il ruolo di default per i nuovi utenti, non permette di accedere alle aree riservate");

--@block
insert into ruoli(nome, descrizione)
values("admin", "Il ruolo che permette l'accesso completo al sito");

--@block
alter table utenti drop column ruolo

--@block
alter table utenti add column ruolo int default '1';

--@block
ALTER TABLE utenti ADD CONSTRAINT FK_ruolo FOREIGN KEY (ruolo) REFERENCES ruoli(id);
