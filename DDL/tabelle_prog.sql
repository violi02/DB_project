CREATE TABLE studente (
    matricola varchar(10) PRIMARY KEY,
    nome varchar(20),
    cognome varchar(20),
    codice_cdl varchar(10) NOT NULL,
    anno integer CHECK (anno > 0 and anno < 4),
    email varchar(50),
    FOREIGN KEY (email) REFERENCES tipo_user(email),
    FOREIGN KEY (codice_cdl) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE
);



CREATE TABLE cdl (
    codice_cdl varchar(10) PRIMARY KEY,
    nome varchar(30),
    responsabile varchar(10) NOT NULL,
    tipo varchar(20) CHECK (tipo in ('triennale','magistrale')),
    descrizione text,
    FOREIGN KEY (responsabile) REFERENCES docente(codice_docente) on update CASCADE
);

CREATE TABLE docente (
    codice_docente varchar(10) PRIMARY KEY,
    nome varchar(20),
    cognome varchar(20),
    email varchar(50),
    FOREIGN KEY (email) REFERENCES tipo_user(email)
);

CREATE TABLE segreteria (
    email varchar(50) PRIMARY KEY,
    FOREIGN KEY (email) REFERENCES tipo_user(email)
);

CREATE TABLE insegnamento (
    codice_i varchar(10),
    codice_cdl varchar(10),
    responsabile varchar(10),
    nome varchar(30),
    anno integer CHECK (anno > 0 and anno < 4),
    descrizione text,
    FOREIGN KEY (codice_cdl) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE,
    FOREIGN KEY (responsabile) REFERENCES docente(codice_docente) on update CASCADE,
    PRIMARY KEY(codice_i,codice_cdl)
);

CREATE TABLE esame (
    codice_esame varchar(10),
    codice_i varchar(10),
    codice_cdl varchar(10),
    data_esame date,
    FOREIGN KEY (codice_cdl) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE,
    FOREIGN KEY (codice_i,codice_cdl) REFERENCES insegnamento(codice_i,codice_cdl) ON UPDATE CASCADE,
    PRIMARY KEY(codice_esame)
);

CREATE TABLE propedeuticità (
  cdl1 varchar(10),
  cdl2 varchar(10),
  c_i1 varchar(10),
  c_i2 varchar(10),
  FOREIGN KEY (cdl1) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE,
  FOREIGN KEY (cdl2) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE,
  FOREIGN KEY (c_i1,cdl1) REFERENCES insegnamento(codice_i,codice_cdl),
  FOREIGN KEY (c_i2,cdl2) REFERENCES insegnamento(codice_i,codice_cdl),
  PRIMARY KEY(cdl1,c_i1,cdl2,c_i2) 
);

-- trigger prima di eliminare direttamente matricola
-- trasferire in carriera esami matricola con tutti i voti
CREATE TABLE carriera_esame (
    matricola varchar(10),
    codice_esame varchar(10),
    voto numeric CHECK( voto>=0 and voto <= 30),
    codice_i varchar(10),
    cdl varchar(10),
    FOREIGN KEY (matricola) REFERENCES studente(matricola) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (codice_esame) REFERENCES esame(codice_esame) ON UPDATE CASCADE,
    FOREIGN KEY (cdl) REFERENCES cdl(codice_cdl),
    FOREIGN KEY (codice_i,cdl) REFERENCES insegnamento(codice_i,codice_cdl),
    PRIMARY KEY(matricola,codice_esame)
);

CREATE TABLE iscrizione_esame (
    matricola varchar(10),
    codice_esame varchar(10),
    FOREIGN KEY (matricola) REFERENCES studente(matricola) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (codice_esame) REFERENCES esame(codice_esame) ON UPDATE CASCADE,
    PRIMARY KEY(matricola,codice_esame)
);

CREATE TABLE utente (
	email varchar(50),
	psw varchar(30),
	tipo_user varchar(20) CHECK (tipo_user IN ('studente','segreteria','docente')),
	PRIMARY KEY(email)
);


CREATE TABLE studente_storico (
    matricola varchar(10) PRIMARY KEY,
    nome varchar(20),
    cognome varchar(20),
    codice_cdl varchar(10) NOT NULL,
    anno integer CHECK (anno > 0 and anno < 4),
    FOREIGN KEY (codice_cdl) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE
);

CREATE TABLE carriera_esame_storico (
    matricola varchar(10),
    codice_esame varchar(10),
    voto numeric CHECK( voto>=0 and voto <= 30),
    codice_i varchar(10),
    codice_cdl varchar(10),
    FOREIGN KEY (matricola) REFERENCES studente_storico(matricola) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (codice_esame) REFERENCES esame(codice_esame) ON UPDATE CASCADE,
    FOREIGN KEY (codice_cdl) REFERENCES cdl(codice_cdl) ON UPDATE CASCADE,
    FOREIGN KEY (codice_i,codice_cdl) REFERENCES insegnamento(codice_i,codice_cdl),
    PRIMARY KEY(matricola,codice_esame)
);
