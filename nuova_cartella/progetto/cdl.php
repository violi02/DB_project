<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
    $db = open_pg_connection();

    
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
    
    $sql = "SELECT * FROM cdl";

    
    $result = pg_query($db, $sql);
    

    $corsi_lauree = array();
    
    while($row = pg_fetch_assoc($result)){
    

        $id_cdl = $row['codice_cdl'];
        $nome = $row['nome'];
        $tipo = $row['tipo'];
        $descrizione = $row['descrizione'];


        $corsi_lauree[$id_cdl] = array($id_cdl,$nome, $tipo, $descrizione);
    }

?>
<h3 class="uk-card-title">CORSI DI LAUREA PRESENTI</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>Codice del corso</th>
		<th>Nome</th>
		<th>Tipo</th>
        <th>Descrizione</th>
	</tr>
</thead>
<tbody>
<?php

foreach($corsi_lauree as $id_cdl=>$values){
    $link = 'cdldetail.php?id=' . $id_cdl;
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