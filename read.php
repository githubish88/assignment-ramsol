<?php
require 'database.php';
$items = [];
$sql = "SELECT `id`, `name`, `email`, `phone`, `city` FROM items ORDER BY `items`.`id` ASC";

if($result = mysqli_query($con,$sql)) {
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {

        $items[$i]['id']        = $row['id'];
        $items[$i]['name']      = $row['name'];
        $items[$i]['email']     = $row['email'];
        $items[$i]['phone']     = $row['phone'];
        $items[$i]['city']      = $row['city'];
        $i++;
    }

    echo json_encode($items);
} else {
  http_response_code(404);
}
?>