<?php

require "connection.php";

$fname = $_POST["first_name"];
$lname = $_POST["last_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];

if (empty($fname)) {
    echo ("Please enter your first name !!!");
} else if (strlen($fname) > 50) {
    echo ("First name must have less than 50 characters.");
} else if (empty($lname)) {
    echo ("Please enter your last name !!!");
} else if (strlen($lname) > 50) {
    echo ("Last name must have less than 50 characters.");
} else if (empty($email)) {
    echo ("Please enter your Email !!!");
} else if (strlen($email) > 100) {
    echo ("Email must have less than 100 characters.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email !!!");
}else if (empty($phone)) {
    echo ("Please enter your mobile !!!");
} else if (strlen($phone) != 10) {
    echo ("Mobile must have 10 characters.");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $phone)) {
    echo ("Invalid mobile !!!");
} else if (empty($password)) {
    echo ("Please enter your password !!!");
} else if (strlen($password) < 5 || strlen($password) > 20) {
    echo ("Password must be between 5 - 20 characters.");
}  else {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' OR `contact_num`='" . $phone . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num > 0) {
        echo ("User with same email or mobile already exists !!!");
    } else {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`
        (`fname`,`lname`,`email`,`contact_num`,`password`,`registered_date`,`status_id`) VALUES
        ('" . $fname . "','" . $lname . "','" . $email . "','" . $phone . "','" . $password . "','" . $date . "','1')");

        echo "success";
    }
}
