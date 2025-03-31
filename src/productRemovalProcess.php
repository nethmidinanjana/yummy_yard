<?php

require "connection.php";

$pid = $_POST["pid"];

if (empty($pid)) {
    echo "Something went wrong. Product ID is missing.";
} else {

    Database::iud("UPDATE foods SET foods.status_id = '2' WHERE foods.id = '" . $pid . "' ");

    echo "Product removed successfully";
}
