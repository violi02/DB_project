<?php
     include_once('lib/funz_progetto.php');
     include_once('lib/header.php');
    $db = open_pg_connection();

   
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
   
    $credenziali = $_GET['id'];
    
    $sql = "SELECT distinct matricola,studente.codice_cdl,insegnamento.codice_i
    from studente inner join insegnamento on studente.codice_cdl = insegnamento.codice_cdl
    where insegnamento.responsabile = (
        SELECT codice_docente
        FROM docente
        WHERE email = '{$credenziali}'
    ) 
    ";

    
    $result = pg_query($db, $sql);
    

    $studenti = array();
    
    while($row = pg_fetch_assoc($result)){
        

        $matricola = $row['matricola'];
        $codice_cdl = $row['codice_cdl'];

        
        
        $studenti[$matricola] = array($matricola, $codice_cdl);


    }

?>
<h3 class="uk-card-title">Studenti con stesso cdl degli insegnamenti di cui sei responsbaile</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
    <th>Matricola</th>
		<th>Codice Cdl</th>
	</tr>
</thead>
<tbody>
<?php

foreach($studenti as $matricola=>$values){
    $link = 'form_voto.php?id=' .$matricola;
?>
    <tr>
        <td><a href="<?php echo $link; ?>"><?php echo $values[0]; ?></a></td>
        <td><?php echo $values[1]; ?></td>
    </tr>
<?php
}
?>
</tbody>
</table>
<?php
    close_pg_connection($db);
?>	