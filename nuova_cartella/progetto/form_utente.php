<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';

    if(isset($_POST) && isset($_POST['utente'])) {
        $utente = $_POST['utente'];
        		
        $email = null;
        if(!empty($utente['email']))
        	$email = $utente['email'];
        else
        	$error_msg = "Errore. E' necessario inserire la mail";


        $tipo_user = null;
            if(!empty($utente['tipo_user']))
                $tipo_user = $utente['tipo_user'];
            else
                $error_msg = "Errore. E' necessario inserire tipo_user";
             
    

		$psw = null;
        if(!empty($utente['psw']))
        	$psw = $utente['psw'];
        else
        	$error_msg = "Errore. E' necessario inserire la password";

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO utente(email,tipo_user,psw) VALUES ($1, $2, $3)";
	
            
            $params = Array();
            $params[] = $email;
            $params[] = $tipo_user;
			$params[] = $psw;

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "Utente inserito correttamente.";
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
	<legend class="uk-legend">Inserisci un nuovo utente</legend>
	<div class="uk-margin">
		<label class="uk-form-label" for="utente-email">Email</label>
		<div class="uk-form-controls">
			<textarea class="uk-input" id="utente-email" type="string" placeholder="Inserisci l'email" name="utente[email]"></textarea>
		</div>
	</div>
    <div class="uk-margin">     
		<label class="uk-form-label" for="utente-tipo_user">Tipo Utente</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="utente-tipo_user" type="string" placeholder="inserisci tipo di utente" name="utente[tipo_user]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="utente-psw">Password</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="utente-psw" type="text" placeholder="inserisci la password" name="utente[psw]">
		</div>
	</div>
	
	<button class="uk-button uk-button-default">Inserisci</button>
</form>