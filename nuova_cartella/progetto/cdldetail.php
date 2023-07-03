<?php
 include_once('lib/funz_progetto.php');
 include_once('lib/header.php');
    $db = open_pg_connection();


    $result = pg_query($db, 'SET SEARCH_PATH TO public');

    $codice = $_GET['id'];
    
    $sql = "SELECT * FROM insegnamento WHERE insegnamento.codice_cdl = '{$codice}'" ;

    
    $result = pg_query($db, $sql);
    


    $insegnamento = array();
     
    while($row = pg_fetch_assoc($result)){
       

        $id = $row['codice_i'];
        $cdl = $row['codice_cdl'];
        $resp = $row['responsabile'];
        $nome = $row['nome'];
        $anno = $row['anno'];
        $descrizione = $row['descrizione'];


        $insegnamento[$id] = array($id,$cdl,$resp,$nome,$anno,$descrizione);
    }

?>
<h3 class="uk-card-title">INSEGNAMENTI PER CORSO DI LAUREA</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>CODICE INSEGNAMENTO</th>
		<th>CODICE CORSO DI LAUREA</th>
		<th>RESPONSABILE</th>
        <th>NOME</th>
        <th>ANNO</th>
        <th>DESCRIZIONE</th>
	</tr>
</thead>
<tbody>
<?php

foreach($insegnamento as $id=>$values){
    
?>
    <tr>
        <td><a href="<?php echo $link; ?>"><?php echo $values[0]; ?></a></td>
        <td><?php echo $values[1]; ?></td>
        <td><?php echo $values[2]; ?></td>
        <td><?php echo $values[3]; ?></td>
        <td><?php echo $values[4]; ?></td>
        <td><?php echo $values[5]; ?></td>
    </tr>
<?php
}
?>
</tbody>
</table>
<?php
    close_pg_connection($db);
?>	