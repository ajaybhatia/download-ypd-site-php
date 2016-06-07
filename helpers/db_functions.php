<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once 'db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }


    /**
     * Gets Build Data by Device name
     */
    public function getBuildDate($deviceName) {
        return mysql_query("SELECT * FROM build WHERE device=" . $deviceName);
    }
   	
}

?>
