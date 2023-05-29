<?php

class Database {
    
    public static function getConnection()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        $conn->set_charset('utf8mb4');
        return $conn;
    }
}


?>