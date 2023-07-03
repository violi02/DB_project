<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';

    if(isset($_POST) && isset($_POST['studente'])) {
        $studente = $_POST['studente'];
        // print_r ($studente);
        
        $matricola = null;
        if(!empty($studente['matricola']))
        	$matricola = $studente['matricola'];
        else
        	$error_msg = "Errore. E' necessario inserire la matricola";
        	
        $nome = null;
        if(!empty($studente['nome']))
        	$nome = $studente['nome'];
        else
        	$error_msg = "Errore. E' necessario inserire il nome";
        	
        $cognome = null;
        if(!empty($studente['cognome']))
        		$cognome = $studente['cognome'];
        else
            $error_msg = "Errore. E' necessario inserire il cognome";
                
        
        		
        $codice_cdl = null;
        if(!empty($studente['codice_cdl']))
        		$codice_cdl = $studente['codice_cdl'];
         else
            $error_msg = "Errore. E' necessario inserire il codice della laurea";
                
        		
        $anno = null;
        if(!empty($studente['anno']))
        	if (is_numeric($studente['anno']))
        		$anno = $studente['anno'];
        		
        $email = null;
        if(!empty($studente['email']))
        	$email = $studente['email'];
        else
        	$error_msg = "Errore. E' necessario inserire la mail";

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO studente(matricola, nome, cognome, codice_cdl, anno, email) VALUES ($1, $2, $3, $4, $5, $6)";
	
            
            $params = Array();
            $params[] = $matricola;
            $params[] = $nome;
            $params[] = $cognome;
            $params[] = $codice_cdl;
            $params[] = $anno;
            $params[] = $email;

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "Studente inserito correttamente.";
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
	<legend class="uk-legend">Inserisci un nuovo studente</legend>

	<div class="uk-margin">     
		<label class="uk-form-label" for="studente-matricola">Matricola</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="studente-matricola" type="text" placeholder="inserisci la matricola" name="studente[matricola]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="studente-nome">Nome</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="studente-nome" type="text" placeholder="inserisci il nome" name="studente[nome]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="studente-cognome">Cognome</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="studente-cognome" type="text" placeholder="inserisci il cognome" name="studente[cognome]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="studente-codice_cdl">Codice cdl</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="studente-codice_cdl" type="text" placeholder="inserisci cdl" name="studente[codice_cdl]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="studente-anno">Anno</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="studente-anno" step="1" type="number" min ='1' max='3' placeholder="Anno" name="studente[anno]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="studente-email">Email</label>
		<div class="uk-form-controls">
			<textarea class="uk-input" type="text" placeholder="Inserisci l'email" name="studente[email]"></textarea>
		</div>
	</div>
	<!--<div class="uk-margin">
		<label class="uk-form-label" for="studente-email">Password</label>
		<div class="uk-form-controls">
			<textarea class="uk-input" rows="5" placeholder="Inserisci la password" name="studente[psw]"></textarea>
		</div>
	</div>-->
	
	<button class="uk-button uk-button-default">Inserisci</button>
</form>