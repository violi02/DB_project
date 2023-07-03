<?php
 include_once('lib/funz_progetto.php');
 include_once('lib/header.php');
    $db = open_pg_connection();


    $result = pg_query($db, 'SET SEARCH_PATH TO public');

    
    $sql = "SELECT * FROM studente" ;
    
    $result = pg_query($db, $sql);
    
    $studenti = array();
    
    while($row = pg_fetch_assoc($result)){
        

        $id = $row['matricola'];
        $nome = $row['nome'];
        $cognome= $row['cognome'];
        $codice_cdl = $row['codice_cdl'];
        $anno = $row['anno'];
        $email = $row['email'];
        $studenti[$email] = array($id,$nome,$cognome,$codice_cdl,$anno,$email);

    }
?>
<h3 class="uk-card-title">ELENCO STUDENTI</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>MATRICOLA</th>
		<th>NOME</th>
        <th>COGNOME</th>
        <th>CODICE CDL</th>
        <th>ANNO</th>
        <th>EMAIL</th>
	</tr>
</thead>
<tbody>
<?php

foreach($studenti as $email=>$values){
   $link = 'cval_per_studente.php?id='.$email;
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