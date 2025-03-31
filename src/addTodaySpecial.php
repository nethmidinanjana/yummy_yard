<?php
session_start();
require 'connection.php';

$title = $_POST['special-title'];
$description = $_POST['special-product-description'];
$foods_id = $_POST['special-id'];

if (empty($title)) {
    echo ("Enter Title");
} else if (empty($description)) {
    echo ("Enter Description");
} else if (empty($foods_id)) {
    echo ("Enter food id");
} else {

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $upload_directory = '../resources/special_images/';
        $file_name = basename($_FILES['file']['name']);
        $target_file = $upload_directory . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $image_url = 'resources/special_images/' . $file_name;
        } else {
            die('Failed to move uploaded file.');
        }
    } else {
        $image_url = null;
    }


    // Update query
    $result = Database::iud("UPDATE todays_special SET `title` = '$title', `description` = '$description', `foods_id` = '$foods_id', `img_url` = '$image_url' WHERE `id` = '1'");

    echo 'success';
}
