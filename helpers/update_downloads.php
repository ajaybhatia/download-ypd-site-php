<?php 

require_once 'db_functions.php';

$id = $_GET['id'];

$instance = new DB_Functions();
echo $instance->updateAndGetDownloads($id);

?>