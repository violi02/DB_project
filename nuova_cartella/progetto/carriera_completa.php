<?php
 include_once('lib/funz_progetto.php');
 include_once('lib/header.php');
    $db = open_pg_connection();

    $result = pg_query($db, 'SET SEARCH_PATH TO public');

    $credenziali = $_GET['id'];
    
    $sql = "SELECT * FROM carriera_esame 
    WHERE  matricola = (
        select matricola 
        from studente 
        where email = '{$credenziali}')" ;

    $result = pg_query($db, $sql);
    
    $esami = array();
    
    while($row = pg_fetch_assoc($result)){
        

        $id = $row['matricola'];
        $c_esame = $row['codice_esame'];
        $voto = $row['voto'];
        $codice_i = $row['codice_i'];
        $codice_cdl = $row['cdl'];
        $esami[$c_esame] = array($id,$c_esame,$voto,$codice_i,$codice_cdl);

    }
?>
<h3 class="uk-card-title">CARRIERA ESAMI COMPLETA</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>MATRICOLA</th>
		<th>CODICE ESAME</th>
        <th>VOTO</th>
        <th>CODICE INSEGNAMENTO</th>
        <th>CODICE CDL</th>
	</tr>
</thead>
<tbody>
<?php
foreach($esami as $id=>$values){
?>
    <tr>
        <td><a href="<?php echo $link; ?>"><?php echo $values[0]; ?></a></td>
        <td><?php echo $values[1]; ?></td>
        <td><?php echo $values[2]; ?></td>
        <td><?php echo $values[3]; ?></td>
        <td><?php echo $values[4]; ?></td>
    </tr>
<?php
}
?>
</tbody>
</table>
<?php
    close_pg_connection($db);
?>	