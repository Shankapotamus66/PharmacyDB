<?php
    include_once('connect.php');
    
    if(isset($_POST['delete-submit'])) {
        session_start();
        $query = pg_query($dbconn, "SELECT deleteCustomer(".$_Session['c_id'].");");
        $_SESSION = array();
        header("Location: ./index.php");
        exit();
    }