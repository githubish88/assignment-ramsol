<?php 
require 'database.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $items = new stdClass();
    $sql = "SELECT `id`, `name`, `email`, `phone`, `city` FROM items WHERE `id` = ".$id." LIMIT 1";
    if($result = mysqli_query($con,$sql)) {
        while($row = mysqli_fetch_assoc($result)) {

            $items->id      = $row['id'];
            $items->name    = $row['name'];
            $items->email   = $row['email'];
            $items->phone   = $row['phone'];
            $items->city    = $row['city'];
        }

        echo json_encode($items);
    } else {
      http_response_code(404);
    }
}
?>