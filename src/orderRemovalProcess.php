<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    $oid = $_POST["oid"];

    if (empty($oid)) {
        echo ("Something went wrong. ");
    } else {
        
        Database::iud("UPDATE invoice SET status_id = '2' WHERE order_id = '" . $oid . "'");

        echo ("success");
    }
}
