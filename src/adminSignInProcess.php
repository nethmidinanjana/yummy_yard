<?php

session_start();

require "connection.php";

$email = $_POST["e"];
$password = $_POST["p"];

if (empty($email) || empty(($password))) {
    echo ("Please enter your details !!!");
} else {

    $user_rs = Database::search("SELECT * FROM `admin` WHERE `email`= '" . $email . "' AND `password`='" . $password . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {
        echo ("success");
        $user_data = $user_rs->fetch_assoc();
        $_SESSION["au"] = $user_data;
    } else {
        echo ("Invalid user name or password");
    }
}
