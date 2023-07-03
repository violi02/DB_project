<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';

    if(isset($_POST) && isset($_POST['cdl'])) {
        $cdl = $_POST['cdl'];
        
        $codice_cdl = null;
        if(!empty($cdl['codice_cdl']))
        		$codice_cdl = $cdl['codice_cdl'];
         else
            $error_msg = "Errore. E' necessario inserire il codice della laurea";
                
        
        $nome = null;
        if(!empty($cdl['nome']))
        	$nome = $cdl['nome'];
        else
        	$error_msg = "Errore. E' necessario inserire il nome";
        	
        
        		
        $tipo = null;
        if(!empty($cdl['tipo']))
        		$tipo = $cdl['tipo'];
        		
        $descrizione = null;
        if(!empty($cdl['descrizione']))
        	$descrizione = $cdl['descrizione'];
        else
        	$error_msg = "Errore. E' necessario inserire la mail";

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO cdl(codice_cdl,nome, tipo, descrizione) VALUES ($1, $2, $3, $4)";
	
            
            $params = Array();
            $params[] = $codice_cdl;
            $params[] = $nome;
            $params[] = $tipo;
            $params[] = $descrizione;
			/*$params[] = $psw;*/

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "cdl inserito correttamente.";
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
	<legend class="uk-legend">Inserisci un nuovo cdl</legend>

	<div class="uk-margin">     
		<label class="uk-form-label" for="cdl-codice_cdl">Codice</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="cdl-codice_cdl" type="text" placeholder="inserisci il codice" name="cdl[codice_cdl]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="cdl-nome">Nome</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="cdl-nome" type="text" placeholder="inserisci il nome" name="cdl[nome]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="cdl-tipo">Tipo</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="cdl-tipo" type="text" placeholder="inserisci il tipo" name="cdl[tipo]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="cdl-descrizione">Descrizione</label>
		<div class="uk-form-controls">
        <textarea class="uk-textarea" rows="5" placeholder="Inserisci la descrizione" name="cdl[descrizione]"></textarea>
		</div>
	</div>
	
	<button class="uk-button uk-button-default">Inserisci</button>
</form>