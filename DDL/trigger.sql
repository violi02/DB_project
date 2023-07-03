-- storico studenti

CREATE OR REPLACE FUNCTION mantain_deleted_student() RETURNS TRIGGER AS $$
begin
insert into studente_storico values(old.matricola,old.nome,old.cognome,old.codice_cdl,old.anno);
insert into carriera_esame_storico
		select * from carriera_esame where matricola = old.matricola;
return old;
end;

$$ language 'plpgsql';

create trigger storico_trigger
before delete
on studente
for each row execute function mantain_deleted_student();


-------------- check max 3 insegnamenti
CREATE OR REPLACE FUNCTION check_max_insegnamenti() RETURNS TRIGGER AS $$
declare 
num_insegnamenti INT;
BEGIN 
    
        SELECT COUNT(codice_i) into num_insegnamenti
        FROM insegnamento INNER JOIN docente ON insegnamento.responsabile = docente.codice_docente
        where new.responsabile = docente.codice_docente;

        IF num_insegnamenti >=3 then
            raise info 'Non puoi assegnare altri insegnamenti al docente';
            return null;
        else 
            return new;
        end if;
END;
$$ language 'plpgsql';

CREATE TRIGGER check_max_ins_trigger
before insert or update 
on insegnamento
for each row execute function check_max_insegnamenti();


-- date differenti trigger
CREATE OR REPLACE FUNCTION check_data_esame() RETURNS TRIGGER AS $$
BEGIN
perform *
from insegnamento inner join esame ON insegnamento.codice_i = esame.codice_i
where esame.codice_cdl = new.codice_cdl AND esame.data_esame = new.data_esame AND insegnamento.anno = (
    select anno 
    from insegnamento 
    where insegnamento.codice_cdl = new.codice_cdl AND insegnamento.codice_i = new.codice_i 
);

IF FOUND THEN RAISE 'non puoi aggiungere questo esame in questa data, scegline una diversa'; 
RETURN NULL;
ELSE 
RETURN NEW;
END IF;
END;
$$ language 'plpgsql';

CREATE TRIGGER trigger_esame 
before insert or update 
on esame 
for each row execute function check_data_esame() ;

-- correttezza iscrizioni esami con propeduticità

CREATE OR REPLACE FUNCTION correttezza_iscrizione() RETURNS TRIGGER AS $$
DECLARE 
num_esami INT;
BEGIN

with esami_che_mancano as( 
SELECT propedeuticità.c_i2 -- query che restituisce codice insegnamento esame a cui ci si vuole iscrivere con rispettivi insegnamenti prop
FROM esame inner join insegnamento on esame.codice_i = insegnamento.codice_i  inner join propedeuticità on esame.codice_i = propedeuticità.c_i1
WHERE esame.codice_cdl = insegnamento.codice_cdl  and esame.codice_esame = new.codice_esame
EXCEPT 
SELECT codice_i
FROM carriera_esame
WHERE carriera_esame.matricola = new.matricola and carriera_esame.voto >= 18
)
select count(*) into num_esami
from esami_che_mancano;

if num_esami > 0 then
   raise info 'Non puoi iscriverti perchè non hai passato tutti gli esami propedeutici';
   RETURN NULL;
ELSE 
RETURN NEW;
END IF;

END;
$$ LANGUAGE 'plpgsql';

create trigger iscrizione_trigger 
before insert on iscrizione_esame
for each row execute function correttezza_iscrizione();





