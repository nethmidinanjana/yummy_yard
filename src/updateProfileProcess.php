<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $mobile = $_POST["mobile"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $province = $_POST["province"];
    $district = $_POST["district"];
    $city = $_POST["city"];
    $gender = $_POST["gender"];

    if (empty($mobile) || empty($line1) || empty($line2) || $province == 0 || $district == 0 || $city == 0) {
        echo "Please fill in all required fields!";
    } else if (strlen($mobile) != 10) {
        echo ("Mobile must have 10 characters.");
    } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
        echo ("Invalid mobile !!!");
    } else {

        Database::iud("UPDATE `user` SET `fname` = '".$fname."', `lname` = '".$lname."', `contact_num`='" . $mobile . "', `gender_id` = '" . $gender . "' WHERE `email`='" . $_SESSION["u"]["email"] . "'");

        $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["u"]["email"] . "' ");
        $user_data = $user_rs->fetch_assoc();

        $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_id`='" . $user_data["id"] . "'");
        $address_num = $address_rs->num_rows;

        if ($address_num == 1) {

            Database::iud("UPDATE `user_has_address` SET `line1`='" . $line1 . "',
                    `line2`='" . $line2 . "',
                    `city_id`='" . $city . "'
                     WHERE `user_id`='" . $user_data["id"] . "'");
        } else {

            Database::iud("INSERT INTO `user_has_address` 
                    (`line1`,`line2`,`user_id`,`city_id`) VALUES 
                    ('" . $line1 . "','" . $line2 . "','" . $user_data["id"] . "','" . $city . "')");
        }

        echo ("success");
    }
} else {
    echo ("Please Login first.");
}
