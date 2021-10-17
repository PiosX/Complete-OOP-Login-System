<?php
    namespace Class\Config;

    use Exception;
    use PDO;

    class Dbh 
    {
        public function connect() {
            require_once("db_config.php");
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'UTF8'",
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
            try {
                $pdo = 'mysql:host='.DB_HOST.";dbname=".DB_DATABASE;
                $con = new PDO($pdo, DB_USER, DB_PASSWORD, $options);
                $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            }catch(Exception $e) {
                echo "Error: ".$e->getMessage();
            }
        }
    }