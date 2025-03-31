<?php

session_start();

require "connection.php";

$email = $_POST["e"];
$password = $_POST["p"];
$rememberme = $_POST["r"];

if (empty($email) || empty(($password))) {
    echo ("Please enter your details !!!");
} else {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`= '" . $email . "' AND `password`='" . $password . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {

        echo ("success");
        $user_data = $user_rs->fetch_assoc();
        $_SESSION["u"] = $user_data;

        if ($rememberme == "true") {

            setcookie("email", $email, time() + (60 * 60 * 24 * 365));
            setcookie("password", $password, time() + (60 * 60 * 24 * 365));
        } else {

            setcookie("email", "", -1);
            setcookie("password", "", -1);
        }
    } else {
        echo ("Invalid user name or password");
    }
}
