<?php

require "connection.php";

$uid = $_POST["uid"];

if (empty($uid)) {
    echo "Something went wrong. Product ID is missing.";
} else {

    Database::iud("UPDATE `user` SET `status_id` = '2' WHERE `id` = '" . $uid . "' ");

    echo "User Blocked successfully";
}
