<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';


    if(isset($_POST) && isset($_POST['carriera_esame'])) {
        $carriera_esame = $_POST['carriera_esame'];
        
        $matricola = null;
        if(!empty($carriera_esame['matricola']))
        		$matricola = $carriera_esame['matricola'];
         else
            $error_msg = "Errore. E' necessario inserire matricola";
                
        
        $codice_esame = null;
        if(!empty($carriera_esame['codice_esame']))
        	$codice_esame = $carriera_esame['codice_esame'];
        else
        	$error_msg = "Errore. E' necessario inserire il codice del corso";
        	
        		
        $voto = null;
        if(!empty($carriera_esame['voto']))
        	if (is_numeric($carriera_esame['voto']))
        		$voto = $carriera_esame['voto'];
        		
        $codice_i = null;
        if(!empty($carriera_esame['codice_i']))
                $codice_i = $carriera_esame['codice_i'];
         else
                $error_msg = "Errore. E' necessario inserire il codice insegnamento";
        
        $cdl = null;
        if(!empty($carriera_esame['cdl']))
                $cdl = $carriera_esame['cdl'];
            else
         $error_msg = "Errore. E' necessario inserire il cdl";
        

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO carriera_esame(matricola,codice_esame,voto,codice_i,cdl) VALUES ($1, $2, $3, $4,$5)";
	
            
            $params = Array();
            $params[] = $matricola;
            $params[] = $codice_esame;
            $params[] = $voto;
            $params[] = $codice_i;
            $params[] = $cdl;
			

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "Voto inserito correttamente.";
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
	<legend class="uk-legend">REGISTRA VOTO</legend>

	<div class="uk-margin">     
		<label class="uk-form-label" for="carriera_esame-matricola">Matricola</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="carriera_esame-matricola" type="text" placeholder="inserisci la matricola" name="carriera_esame[matricola]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="carriera_esame-codice_esame">Codice esame</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="carriera_esame-codice_esame" type="text" placeholder="inserisci il codice_esame" name="carriera_esame[codice_esame]">
		</div>
	</div>
    <div class="uk-margin">
		<label class="uk-form-label" for="carriera_esame-voto">voto</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="carriera_esame-voto" step="1" type="number" min ='1' max='30' placeholder="voto" name="carriera_esame[voto]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="carriera_esame-codice_i">Codice insegnamento</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="carriera_esame-codice_i" type="text" placeholder="inserisci il codice insegnamento" name="carriera_esame[codice_i]">
		</div>
	</div>
    <div class="uk-margin">     
		<label class="uk-form-label" for="carriera_esame-cdl">Corso di Laurea</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="carriera_esame-cdl" type="text" placeholder="inserisci il cdl" name="carriera_esame[cdl]">
		</div>
	</div>

	
	<button class="uk-button uk-button-default">Inserisci</button>
</form>

<?php

    $db = open_pg_connection();
    $matricola = $_GET['id'];
   
    $result = pg_query($db, 'SET SEARCH_PATH TO public');
   
    
    $sql = "SELECT  ISCRIZIONE_ESAME.MATRICOLA,esame.codice_esame,esame.codice_i,esame.data_esame 
    from iscrizione_esame inner join  esame on iscrizione_esame.codice_esame = esame.codice_esame 
    inner join insegnamento on insegnamento.codice_i = esame.codice_i  where iscrizione_esame.matricola = '{$matricola}'
    ";

    
    $result = pg_query($db, $sql);
    

    $studenti = array();
    
    while($row = pg_fetch_assoc($result)){
        

        $matricola = $row['matricola'];
        $codice_esame = $row['codice_esame'];
        $codice_i = $row['codice_i'];
        $data_esame = $row['data_esame'];

        
        
        $studenti[$codice_esame] = array($matricola, $codice_esame,$codice_i,$data_esame);


    }

?>
<h3 class="uk-card-title">Studente iscritti agli esami dei tuoi insegnamenti</h3>
<table class="uk-table uk-table-divider">
<thead>
    <tr>
    
    <th>Matricola</th>
    <th>Codice Esame</th>
    <th>Codice Insegnamento</th>
        <th>Data Esame</th>
    </tr>
</thead>
<tbody>
<?php

foreach($studenti as $codice_esame=>$values){
   
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


