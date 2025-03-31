<?php
session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_POST['qty']) && isset($_POST['pid'])) {
        $qty = $_POST['qty'];
        $pid = $_POST['pid'];
        $uid = $_SESSION["u"]["id"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `foods_id`= '" . $pid . "' AND `user_id`='" . $uid . "'");
        $cart_num = $cart_rs->num_rows;

        $product_rs = Database::search("SELECT * FROM `food_details` WHERE `foods_id`='" . $pid . "'");
        $product_data = $product_rs->fetch_assoc();
        $product_qty = $product_data["qty"];

        if ($cart_num == 1) {

            $cart_data = $cart_rs->fetch_assoc();
            $current_qty = $cart_data["qty"];


            if ($product_qty > $qty) {

                Database::iud("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `foods_id`='" . $pid . "' AND `user_id`='" . $uid . "' ");
                echo ("Product Updated");
            } else {
                echo ("Invalid Quantity");
            }
        } else {
            Database::iud("INSERT INTO `cart`(`foods_id`,`user_id`,`qty`) VALUES ('" . $pid . "','" . $uid . "','" . $qty . "')");
            echo ("Product added successfully");
        }
    } else {
        echo "Error: Missing quantity or productId.";
    }
} else {
    echo ("Please Login first!");
}
