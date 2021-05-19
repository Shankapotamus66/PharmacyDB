<?php
    if(isset($_POST['logout-submit'])) {

        session_start();
        $_SESSION = array();
        header("Location: ./index.php");
        exit();
    }