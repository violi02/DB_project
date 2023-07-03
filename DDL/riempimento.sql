-- docente 
INSERT INTO docente VALUES 
('D01','Giovanni','Pighizzini'),
('D02','Valerio','Bellandi'),
('D03','Elena','Conte'),
('D04','Stefano','Montanelli'),
('D05','Luisa','Ghio'),
('D06','Elisabetta','Bruschi');

-- corso di laurea
INSERT INTO cdl VALUES 
('L31','Informatica','D01','triennale','Gli obiettivi del corso di laurea in Informatica sono: da una parte fornire una solida conoscenza di base e metodologica dei principali settori delle scienze informatiche e matematiche '),
('L22','Storia Medievale','D05','magistrale','obiettivo del corso è quello di fornire le linee generali della storia medievale, nonché gli strumenti necessari alla comprensione critica dei principali aspetti politici, economici, sociali e religiosi dei secoli che vanno dal tardoantica al primo Rinascimento.'),
('L33','Fisioterapia','D06','triennale','Il Corso di Laurea in Fisioterapia, appartenente alla Classe delle Lauree delle Professioni Sanitarie della Riabilitazione (Classe L/SNT2), ha durata triennale.');

-- insegnamento
INSERT INTO insegnamento VALUES 
('P01','L31','D02','Programmazione 1',1,'Il corso di programmazione 1 prevede...'),
('ALGO01','L31','D01','Algoritmi e Strutture Dati',2,'Il corso di algoritmi e strutture dati...'),
('S01','L22','D03','Storia contemporanea 1',1,'Il corso di storia contemporanea...'),
('R01','L33','D05','Riabilitazione',3,'Il corso di riabilitazione...'),
insert into insegnamento values
('MC01','L31','D02','Matematica del Continuo',1,'Il corso di matematica del continuo'),
('PWM01','L31','D01','Programmazione web e mobile',3,'Il corso di pwm...');


-- studente
INSERT INTO studente VALUES 
('S001','Viola','Licata','L31','2'),
('S002','Chiara','Brambati','L31','2'),
('S003','Simone','Marchetti','L33','3'),
('S004','Luca','Noci','L22','1');

-- esame
INSERT INTO esame VALUES 
('EP01','P01','L31','2023/06/12'),
('EALGO01','ALGO01','L31','2023/06/22'),
('EALGO02','ALGO01','L31','2023/07/07'),
('EP02','P01','L31','2023/06/30'),
('EP03','P01','L31','2023/07/14'),
('ES01','S01','L22','2023/06/15'),
('ES02','S01','L22','2023/06/16'),
('ES03','S01','L22','2023/07/15'),
('ER01','R01','L33','2023/06/30'),
('EMC01','MC01','L31','2023/05/12')

-- carriera
INSERT INTO carriera_esame VALUES 
('S001','EP01',7),
('S001','EP02',12),
('S002','EP01',15),
('S002','EP03',29),
('S002','EMC01',22),
('S003','ER01',27),
('S004','ES01',22),
('S004','ES02',28);

-- propedeuticità
INSERT INTO propedeuticità VALUES
('L31','L31','ALGO01','P01'); 
('L31','L31','ALGO01','MC01')


insert into iscrizione_esame values('S002','ALGO01');

-- tabella tipo_user
insert into tipo_user values
('violalicata@studente.uni.it','psw1','studente'),
('chiarabrambati@studente.uni.it','psw2','studente'),
('lucanoci@studente.uni.it','psw3','studente'),
('giovannipighizzini@docente.uni.it','pswgp1','docente'),
('valeriobellandi@docente.uni.it','pswvb1','docente'),
('segreteria.univoco@segreteria.uni.it','pswsegreteria1','segreteria');
