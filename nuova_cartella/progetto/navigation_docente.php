<?php include_once('header.php');?>
<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">

        <ul class="uk-navbar-nav">
            <li><a href="mod_credenziali.php">Modifica Credenziali</a></li>
            <?php  $link = "insegnamenti_per_docente.php?id=".$_POST['usr']; ?> 
            <li><a href="<?php echo $link ?>">CALENDARIO ESAMI</a></li>
            <?php  $link = "verifica_iscrizioni.php?id=".$_POST['usr']; ?> 
            <li><a href="<?php echo $link ?>">REGISTRA VOTI</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>