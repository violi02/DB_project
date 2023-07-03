<?php include_once('header.php');?>
<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">

        <ul class="uk-navbar-nav">
            <li><a href="mod_credenziali.php">Modifica Credenziali</a></li>
            <li>
                <a href="form_utente.php">INSERISCI UTENTE</a>
            <li>
                <a href="#">STUDENTE</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                    <li><a href="form_studente.php">INSERISCI</a></li>
                    <li><a href="drop_studente.php">ELIMINA</a></li>
                        <li><a href="stud_carriera_valida.php">Carriera Valida</a></li>
                    	<li><a href="stud_carriera_completa.php">Carriera Completa</a></li>
                    </ul>
                </div>
        </li>  
        <li>
                <a href="#">DOCENTE</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                    <li><a href="form_docente.php">INSERISCI</a></li>
                    </ul>
                </div>
        </li>  
        <li>
                <a href="#">corso di laurea</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                    <li><a href="form_cdl.php">INSERISCI CORSO DI LAUREA</a></li>
                    <li><a href="form_insegnamento.php">INSERISCI INSEGNAMENTO</a></li>
                    </ul>
                </div>
        </li>    
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>