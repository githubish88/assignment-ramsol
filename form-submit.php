<?php
require 'database.php';

if(isset($_POST['type'])){
    $type = $_POST['type'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];

    if($type == 'new'){

        $sql = "INSERT INTO `items`(`name`, `email`, `phone`, `city`) VALUES ('{$name}','{$email}','{$phone}','{$city}')";
	
        if(mysqli_query($con,$sql)) {

            http_response_code(201);
            $items = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'city' => $city,
                'id' => mysqli_insert_id($con)
            ];
            echo json_encode($actors);
        }
        else
        {
            http_response_code(422);
        }
    } else {
        
        $id = $_POST['id'];
        $sql = "UPDATE `items` SET `name` = '$name', `email` = '$email', `phone` = '$phone', `city` = '$city' WHERE `items`.`id` = '{$id}'  LIMIT 1";
        if(mysqli_query($con, $sql)) {
            http_response_code(204);
        }
    }
}

?>