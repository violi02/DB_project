<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
    $db = open_pg_connection();

   
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
    
    $credenziali = $_GET['id'];

    $sql = "SELECT codice_i,codice_cdl 
        FROM  insegnamento  
        where responsabile = (
        SELECT codice_docente 
        FROM docente
        WHERE email = '{$credenziali}'
    )
    ";

    $result = pg_query($db, $sql);
    

    $insegnamenti = array();
    
    while($row = pg_fetch_assoc($result)){
        // print_r($row)

        $codice_i = $row['codice_i'];
        $codice_cdl = $row['codice_cdl'];


        $insegnamenti[$codice_i] = array($codice_i, $codice_cdl);
    }

?>
<h3 class="uk-card-title">INSEGNAMENTI DI CUI SEI REPONSABILE</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>Codice insegnamento</th>
		<th>Codice cdl</th>
	</tr>
</thead>
<tbody>
<?php

foreach($insegnamenti as $codice_i=>$values){
    $link = 'form_calendario.php?id=' .$codice_i;
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