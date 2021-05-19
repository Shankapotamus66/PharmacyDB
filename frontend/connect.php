<?php

    $dbconn = pg_connect("host = localhost port = 5432 dbname = DBNAME user = DBUSERNAME password = DBPASSWORD");

    if (!$dbconn)
    {
        echo "404 Connection not found";
        exit;
    } else { echo "connected"; }

?>
