<?php
    ini_set ("display_errors", "On");
    ini_set("error_reporting", E_ALL);
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';

    $email = $_GET['id'];
    
    if(isset($_POST) && isset($_POST['utente'])) {
        $utente = $_POST['utente'];
        		
		$psw = null;
        if(!empty($utente['psw']))
        	$psw = $utente['psw'];
        else
        	$error_msg = "Errore. E' necessario inserire la nuova password";

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');

            echo $email;

			$sql = "UPDATE utente SET psw = md5($1) WHERE email = '{$email}'";
	            
            $params = Array();
            $params[] = $psw;
            print_r($params);

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
            $success_msg = "Cambio password avvenuto correttamente.";
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
	<legend class="uk-legend">Inserisci una nuova password</legend>
	<div class="uk-margin">
		<label class="uk-form-label" for="utente-psw">Password</label>
		<div class="uk-form-controls">
			<textarea class="uk-input" id="utente-psw" type="password" placeholder="Password" name="utente[psw]"></textarea>
		</div>
	</div>
	<button class="uk-button uk-button-default">Cambia</button>
</form>