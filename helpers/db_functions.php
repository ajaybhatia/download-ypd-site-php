<?php

class DB_Functions {

    private $db;
    private $con;

    //put your code here
    // constructor
    function __construct() {
        include_once 'db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->con = $this->db->connect();
    }

    // destructor
    function __destruct() {
        $this->db->close();
    }


    /**
     * Gets Build Data by Device name
     */
    public function getBuildDate($deviceName) {
        return $this->con->query("SELECT * FROM build WHERE device='" . $deviceName . "'");
    }
   	
}

?>
