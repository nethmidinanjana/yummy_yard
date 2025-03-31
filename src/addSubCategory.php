<?php

require "connection.php";

$subc = $_POST["txt"];
$c = $_POST["c"];

if (empty($subc)) {
    echo ("Please enter a sub category name.");
} else if ($c == 0) {
    echo ("Please select a category");
} else {
    $cat_rs = Database::search("SELECT * FROM `sub_category` WHERE `name` = '" . $subc . "' AND `categories_id` = '" . $c . "' ");
    $cat_num = $cat_rs->num_rows;

    if ($cat_num == 0) {

        Database::iud("INSERT INTO `sub_category` (`name`, `categories_id`) VALUES ('" . $subc . "', '" . $c . "')");

        echo ("success");
    } else {
        echo ("This sub category already exists in the database.");
    }
}
