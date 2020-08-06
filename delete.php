<?php
require 'database.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM `items` WHERE `items`.`id` = ".$id;
    if(mysqli_query($con, $sql)) {
        http_response_code(204);
    }
}
?>