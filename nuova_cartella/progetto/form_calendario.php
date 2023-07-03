<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';



    if(isset($_POST) && isset($_POST['esame'])) {
        $esame = $_POST['esame'];
        
        $codice_esame = null;
        if(!empty($esame['codice_esame']))
        		$codice_esame = $esame['codice_esame'];
         else
            $error_msg = "Errore. E' necessario inserire il codice dell'esame";

        $codice_i = null;
        if(!empty($esame['codice_i']))
                $codice_i = $esame['codice_i'];
         else
                $error_msg = "Errore. E' necessario inserire il codice dell'insegnamento";
                    
                
        
        $codice_cdl = null;
        if(!empty($esame['codice_cdl']))
        	$codice_cdl = $esame['codice_cdl'];
        else
        	$error_msg = "Errore. E' necessario inserire il codice del corso";
        	
        
        $data_esame = null;
        if(!empty($esame['data_esame']))
        	$data_esame = $esame['data_esame'];
        else
        	$error_msg = "Errore. E' necessario inserire la data";

        

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO esame(codice_esame,codice_i,codice_cdl,data_esame) VALUES ($1, $2, $3, $4)";
	
            
            $params = Array();
            $params[] = $codice_esame;
            $params[] = $codice_i;
            $params[] = $codice_cdl;
            $params[] = $data_esame;

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "esame inserito correttamente.";
            else
                $error_msg = pg_last_error($db);
        }
    }

    // link da usare nella clausola action del form di inserimento
    $pagelink = $_SERVER['PHP_SELF'] . '?mod=insert';
        	
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
<form class="uk-form-horizontal" action="<?php echo $pagelink; ?>" method="POST">
	<legend class="uk-legend">Inserisci un nuovo esame</legend>

	<div class="uk-margin">     
		<label class="uk-form-label" for="esame-codice_esame">Codice Esame</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="esame-codice_esame" type="text" placeholder="inserisci il codice dell'esame" name="esame[codice_esame]">
		</div>
	</div>
    <div class="uk-margin">     
		<label class="uk-form-label" for="esame-codice_i">Codice insegnamento</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="esame-codice_i" type="text" placeholder="inserisci il codice dell'insegnamento" name="esame[codice_i]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="esame-codice_cdl">Codice cdl</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="esame-codice_cdl" type="text" placeholder="inserisci il codice cdl" name="esame[codice_cdl]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="esame-data_esame">Data Esame</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="esame-data_esame" type="date" placeholder="inserisci la data" name="esame[data_esame]">
		</div>
	</div>
    
	<button class="uk-button uk-button-default">INSERISCI ESAME</button>
</form>
<hr class="uk-divider-icon">
<?php
    $db = open_pg_connection();

   
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
    $ins_selez = $_GET['id'];

    $sql = "SELECT codice_esame,codice_i,data_esame
    FROM esame
    WHERE codice_i = '{$ins_selez}'";

    $result = pg_query($db, $sql);
    

    $calendario = array();
    
    while($row = pg_fetch_assoc($result)){
        // print_r($row)

        $codice_e = $row['codice_esame'];
        $codice_i = $row['codice_i'];
        $data_esame = $row['data_esame'];


        $calendario[$codice_e] = array($codice_e, $codice_i, $data_esame);
    }

?>
<h3 class="uk-card-title">CALENDARIO ESAMI PER L'INSEGNAMENTO <?php echo $ins_selez ?></h3>
<table class="uk-table uk-table-divider">
<thead>
	<tr>
		<th>Codice Esame</th>
        <th>Codice Insegnamento</th>
		<th>Data Esame</th>
	</tr>
</thead>
<tbody>
<?php

foreach($calendario as $codice_e=>$values){
   
?>
    <tr>
        <td><a href="<?php echo $link; ?>"><?php echo $values[0]; ?></a></td>
        <td><?php echo $values[1]; ?></td>
        <td><?php echo $values[2]; ?></td>
    </tr>
<?php
}
?>
</tbody>
</table>
<?php
    close_pg_connection($db);
?>	