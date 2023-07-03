<?php
    include_once('lib/funz_progetto.php');
    include_once('lib/header.php');
	$error_msg = '';
	$success_msg = '';

    if(isset($_POST) && isset($_POST['insegnamento'])) {
        $insegnamento = $_POST['insegnamento'];
        
        $codice_i = null;
        if(!empty($insegnamento['codice_i']))
        		$codice_i = $insegnamento['codice_i'];
         else
            $error_msg = "Errore. E' necessario inserire il codice dell'insegnamento";
                
        
        $codice_cdl = null;
        if(!empty($insegnamento['codice_cdl']))
        	$codice_cdl = $insegnamento['codice_cdl'];
        else
        	$error_msg = "Errore. E' necessario inserire il codice del corso";
        	
        
        $responsabile = null;
        if(!empty($insegnamento['responsabile']))
        	$responsabile = $insegnamento['responsabile'];
        else
        	$error_msg = "Errore. E' necessario inserire il responsabile";

        $nome = null;
        if(!empty($insegnamento['nome']))
                $nome = $insegnamento['nome'];
            else
                $error_msg = "Errore. E' necessario inserire il nome";
        		
        $anno = null;
        if(!empty($insegnamento['anno']))
        	if (is_numeric($insegnamento['anno']))
        		$anno = $insegnamento['anno'];
        		
        $descrizione = null;
        if(!empty($insegnamento['descrizione']))
                $descrizione = $insegnamento['descrizione'];
        else
                 $error_msg = "Errore. E' necessario inserire la descrizione";
        

        	
        if (empty($error_msg)) {
        	$db = open_pg_connection();
        	
        	$result = pg_query($db, 'SET SEARCH_PATH TO public');
	
			$sql = "INSERT INTO insegnamento(codice_i,codice_cdl,responsabile,nome,anno,descrizione) VALUES ($1, $2, $3, $4,$5,$6)";
	
            
            $params = Array();
            $params[] = $codice_i;
            $params[] = $codice_cdl;
            $params[] = $responsabile;
            $params[] = $nome;
            $params[] = $anno;
			$params[] = $descrizione;

            $result = pg_prepare($db,"ins_query", $sql);
            $result = pg_execute($db,"ins_query", $params);
            
            if ($result)
                $success_msg = "insegnamento inserito correttamente.";
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
	<legend class="uk-legend">Inserisci un nuovo insegnamento</legend>

	<div class="uk-margin">     
		<label class="uk-form-label" for="insegnamento-codice_i">Codice</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="insegnamento-codice_i" type="text" placeholder="inserisci il codice" name="insegnamento[codice_i]">
		</div>
	</div>
	<div class="uk-margin">     
		<label class="uk-form-label" for="insegnamento-codice_cdl">Codice cdl</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="insegnamento-codice_cdl" type="text" placeholder="inserisci il codice_cdl" name="insegnamento[codice_cdl]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="insegnamento-responsabile">Responsabile</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="insegnamento-responsabile" type="text" placeholder="inserisci il responsabile" name="insegnamento[responsabile]">
		</div>
	</div>
    <div class="uk-margin">     
		<label class="uk-form-label" for="insegnamento-nome">Nome</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="insegnamento-nome" type="text" placeholder="inserisci il nome" name="insegnamento[nome]">
		</div>
	</div>
    <div class="uk-margin">
		<label class="uk-form-label" for="insegnamento-anno">Anno</label>
		<div class="uk-form-controls">
			<input class="uk-input" id="insegnamento-anno" step="1" type="number" min ='1' max='3' placeholder="Anno" name="insegnamento[anno]">
		</div>
	</div>
	<div class="uk-margin">
		<label class="uk-form-label" for="insegnamento-descrizione">Descrizione</label>
		<div class="uk-form-controls">
        <textarea class="uk-textarea" rows="5" placeholder="Inserisci la descrizione" name="insegnamento[descrizione]"></textarea>
		</div>
	</div>
	
	<button class="uk-button uk-button-default">Inserisci</button>
</form>