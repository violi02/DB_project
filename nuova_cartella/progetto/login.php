<?php 
	ini_set ("display_errors", "On");
	ini_set("error_reporting", E_ALL);
	include_once ('lib/funz_progetto.php'); 

    $logged = null;
    session_start();

    if (isset($_POST) && !empty($_POST['usr']) && !empty($_POST['psw']) && !empty($_POST['typeuser'])) {
        // verifica credenziali 
        $logged = check_login(($_POST['usr']),($_POST['psw']),($_POST['typeuser']));

    }

    if (isset($_SESSION['usr'])){
        $logged = $_SESSION['usr'];
       
    }

    if (isset($logged)) {
        $_SESSION['usr'] = $logged;
        
    }

    if (isset($_GET)  && isset($_GET['log']) && $_GET['log']=='del') {
        unset($_SESSION['usr'] );
        $logged = null;
       
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once ('lib/header.php'); ?>
        <title>
       AUTENTICAZIONE
        </title>
    </head>
    <body>
        
        <div class="uk-container uk-margin-bottom uk-margin-top">
            <?php
    if (isset($logged)) {
        $logout_link = $_SERVER['PHP_SELF'] . "?log=del";
    ?>
    <div class="uk-card uk-card-default uk-card-body uk-text-right">
    <p>
        <?php echo("Benvenuto/a $logged"); ?> - 
        <a href="<?php echo($logout_link); ?>">Logout</a> 
    </p>
    </div>
    <?php
    } 
    ?>

    <div class="uk-section uk-section-default">
    
    <?php

     if (is_null($logged)) {
    ?>
    <div class="uk-width-1-3@s uk-container">
    <div class="uk-panel uk-panel-space uk-text-center">
    <form class="uk-form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <legend class="uk-legend">Inserisci le credenziali</legend>

        <div class="uk-inline uk-width-1-1">     
            <input class="uk-input" type="text" placeholder="username" name="usr">
        </div>
        <div class="uk-inline uk-width-1-1">
            <input class="uk-input" type="password" placeholder="password" name="psw">
        </div>
        <div class="uk-inline uk-width-1-1">
        <select name = "typeuser" id = "typeuser" >
        <option value="studente">studente</option>
        <option value="docente">docente</option>
        <option value="segreteria">segreteria</option>
         </select>
        </div>
        <button class="uk-width-1-1 uk-button uk-button-primary uk-button-large uk-margin-small-top">Esegui il login</button>
    </form>
    </div>
    </div>
    <?php
    } else {
    ?>
    

    <div uk-grid>
           
            <div class="uk-width-2-3">
                <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-text-left">
                 <?php
                    if (isset($_POST) && isset($_POST['typeuser'])) {
                        switch ($_POST['typeuser']) {
                        case 'studente':
                            include_once('navigation_studente.php');  
                            break;
                        case 'docente':
                            include_once('navigation_docente.php'); 
                            break;
                        case 'segreteria':
                            include_once('navigation_segreteria.php');   
                            break;
                        default:
                            include_once('login.php'); 
                            break;
                        }
                    } 
                ?>       
                </div>
            </div>
        </div>
<?php
    }
?>
	</div>
    </body>
</html>