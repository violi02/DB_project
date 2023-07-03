<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
    $db = open_pg_connection();

   
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
    
    $credenziali = $_GET['id'];

    $sql = "SELECT *
    FROM esame
    WHERE codice_cdl = (
        select codice_cdl
        from studente
        where email = '{$credenziali}'
    )";

    $result = pg_query($db, $sql);
    

    $insegnamenti = array();
    
    while($row = pg_fetch_assoc($result)){
        
        $id_esame = $row['codice_esame'];
        $codice_i = $row['codice_i'];
        $codice_cdl = $row['codice_cdl'];
        $data = $row['data_esame'];


        $insegnamenti[$id_esame] = array($id_esame,$codice_i, $codice_cdl, $data);
    }

?>
<h3 class="uk-card-title">ESAMI DEL TUO CORSO DI LAUREA</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>Codice esame</th>
		<th>Codice insegnamento</th>
		<th>Codice cdl</th>
        <th>Data esame</th>
	</tr>
</thead>
<tbody>
<?php

foreach($insegnamenti as $id_esame=>$values){
    $link = 'form_iscrizione.php?id='.$credenziali.'&codice='.$id_esame;
?>
    <tr>
        <td><a href="<?php echo $link; ?>"><?php echo $values[0]; ?></a></td>
        <td><?php echo $values[1]; ?></td>
        <td><?php echo $values[2]; ?></td>
        <td><?php echo $values[3]; ?></td>
    </tr>
<?php
}
?>
</tbody>
</table>
<?php
    close_pg_connection($db);
?>	