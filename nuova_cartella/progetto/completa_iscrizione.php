<?php
	$error_msg = '';
	$success_msg = '';
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');


    $codice_esame = $_GET['id'];
    $matricola = $_GET['usr'];
    
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO iscrizione_esame(matricola, codice_esame) VALUES ('{$matricola}','{$codice_esame}')";
	
            
            $params = Array();
            $params[] = $matricola;
            $params[] = $codice_esame;

            $result = pg_prepare($db, "ins_query", $sql);
            $result = pg_execute($db, "ins_query", $params);
            
            if ($result)
                $success_msg = "Ti sei iscritto all'esame correttamente!";
            else
                $error_msg = pg_last_error($db);
     	
        
?>
<?php
if (!empty($success_msg)) {
?>
<div class="uk-alert-success" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $success_msg; ?></p>
</div>
<?php
}
?>
<?php
if (!empty($error_msg)) {
?>
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $error_msg; ?></p>
</div>
<?php
}
?>
