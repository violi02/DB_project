<?php


/*
Open connection with PostgreSQL server
*/
function open_pg_connection() {
	include_once('conf/conf.php');
    
    $connection = "host=".myhost." dbname=".mydb." user=".myuser." password=".mypsw;
    
    return pg_connect ($connection);
    
}

/*
Close connection with PostgreSQL server
*/
function close_pg_connection($db) {
        
    return pg_close ($db);
    
}

/*
check the validity of given credentials
*/
function check_login($usr, $psw,$typeuser) {
    
    $logged = null;

    $db = open_pg_connection();
    

    $sql = "SELECT email FROM utente WHERE email = $1 AND psw = md5($2) and tipo_user = $3";

    $params = array(
    	$usr,
    	$psw,
		$typeuser
    );

    $result = pg_prepare($db, "check_user", $sql);
    $result = pg_execute($db, "check_user", $params);

    if($row = pg_fetch_assoc($result)){
    	$logged = $row['email'];
    }

    close_pg_connection($db);

    return $logged;
    
}

?>