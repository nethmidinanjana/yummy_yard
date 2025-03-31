<?php

require "connection.php";

if (isset($_GET["c"])) {

    $category_id = $_GET["c"];

    $sub_category_rs = Database::search("SELECT * FROM `sub_category` WHERE `categories_id`= '" . $category_id . "' ");
    $sub_category_num = $sub_category_rs->num_rows;

    for ($i = 0; $i < $sub_category_num; $i++) {
        $sub_category_data = $sub_category_rs->fetch_assoc();

?>

        <option value="<?php echo $sub_category_data["id"]; ?>"><?php echo $sub_category_data["name"]; ?></option>

<?php
    }
}

?>