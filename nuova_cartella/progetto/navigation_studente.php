<?php include_once('header.php');?>
<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">


        <ul class="uk-navbar-nav">
            <?php  $link = "mod_credenziali.php?id=".$_POST['usr']; ?> 
            <li><a href="<?php echo $link ?>">Modifica Credenziali</a></li>
            <?php  $link = "iscrizioni_esami.php?id=".$_POST['usr']; ?> 
            <li><a href="<?php echo $link ?>">ISCRIZIONE ESAMI</a></li>
            <li>
                <a href="#">CARRIERA ESAMI</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                    <?php  $link = 'carriera_valida.php?id='.$_POST['usr']; ?> 
                        <li><a href="<?php echo $link ?>" >Carriera Valida</a></li>
                        <?php  $link = 'carriera_completa.php?id='.$_POST['usr']; ?> 
                    	<li><a href="<?php echo $link ?>">Carriera Completa</a></li>
                    </ul>
                </div>
</li>
            <li>
                <a href="cdl.php">CORSI DI LAUREA</a>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>