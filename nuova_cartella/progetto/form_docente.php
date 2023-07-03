<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';

    if(isset($_POST) && isset($_POST['docente'])) {
        $docente = $_POST['docente'];
        // print_r ($docente);
        
        $codice_docente = null;
        if(!empty($docente['codice_docente']))
        	$codice_docente = $docente['codice_docente'];
        else
        	$error_msg = "Errore. E' necessario inserire il codice_docente";
        	
        $nome = null;
        if(!empty($docente['nome']))
        	$nome = $docente['nome'];
        else
        	$error_msg = "Errore. E' necessario inserire il nome";
        	
        $cognome = null;
        if(!empty($docente['cognome']))
        		$cognome = $docente['cognome'];
        else
            $error_msg = "Errore. E' necessario inserire il cognome";
                
        
        $email = null;
        if(!empty($docente['email']))
        	$email = $docente['email'];
        else
        	$error_msg = "Errore. E' necessario inserire la mail";

		/*$psw = null;
        if(!empty($docente['psw']))
        	$psw= $docente['psw'];
        else
        	$error_msg = "Errore. E' necessario inserire la password";
        	*/
        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO docente(codice_docente, nome, cognome, email) VALUES ($1, $2, $3, $4)";
	
            
            $params = Array();
            $params[] = $codice_docente;
            $params[] = $nome;
            $params[] = $cognome;
            $params[] = $email;
			/*$params[] = $psw;*/

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "docente inserito correttamente.";
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
	<legend class="uk-legend">Inserisci un nuovo docente</legend>

	<div class="uk-margin">     
		<label class="uk-form-label" for="docente-codice_docente">Codice</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="docente-codice_docente" type="text" placeholder="inserisci il codice_docente" name="docente[codice_docente]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="docente-nome">Nome</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="docente-nome" type="text" placeholder="inserisci il nome" name="docente[nome]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="docente-cognome">Cognome</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="docente-cognome" type="text" placeholder="inserisci il cognome" name="docente[cognome]">
		</div>
	</div>
	
	<div class="uk-margin">
		<label class="uk-form-label" for="docente-email">Email</label>
		<div class="uk-form-controls">
			<textarea class="uk-input" type="text" placeholder="Inserisci l'email" name="docente[email]"></textarea>
		</div>
	</div>

	
	<button class="uk-button uk-button-default">Inserisci</button>
</form>