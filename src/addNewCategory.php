<?php

require "connection.php";

$category = $_POST["txt"];

if (empty($category)) {
    echo ("Please enter a category name.");
} else {
    $cat_rs = Database::search("SELECT * FROM `categories` WHERE `name` = '" . $category . "'");
    $cat_num = $cat_rs->num_rows;

    if ($cat_num == 0) {

        Database::iud("INSERT INTO `categories` (`name`) VALUES ('" . $category . "')");

        echo ("success");
    } else {
        echo ("This category already exists in the database.");
    }
}
