<?php 
    ini_set ("display_errors", "On");
    ini_set("error_reporting", E_ALL);
    
?>
<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
    $db = open_pg_connection();

    $email = $_GET['id'];
    $codice_esame = $_GET['codice'];
   
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
    
    $sql = "SELECT matricola
            from studente 
            where email = '{$email}'  ";

    
    $result = pg_query($db, $sql);
    $matricola = '';
    while($row = pg_fetch_assoc($result)){   
        $matricola = $row['matricola'];
    }
    
     
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
    $sql = "INSERT INTO iscrizione_esame(matricola, codice_esame) VALUES ($1, $2)";

    $params = Array();
            $params[] = $matricola;
            $params[] = $codice_esame;
            
    if ($result)
                $success_msg = "iscrizione avvenuta";
            else
                $error_msg = pg_last_error($db);
            

    $result = pg_prepare($db,"ins_query", $sql);
    $result = pg_execute($db, "ins_query",$params);
            
?>
<h3 class="uk-card-title">Iscrizione Effettuata</h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
        <th>Codice Esame</th>
        <th>Matricola </th>
	</tr>
</thead>
<tbody>
    <tr>
        <td><?php echo $codice_esame ?></td>
        <td><?php echo $matricola?></td> 
    </tr>

</tbody>
</table>
<?php
    close_pg_connection($db);
?>	

