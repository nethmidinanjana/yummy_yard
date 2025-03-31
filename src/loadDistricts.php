<?php

require "connection.php";

if (isset($_GET["p"])) {

    $province_id = $_GET["p"];

    $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id`= '" . $province_id . "' ");
    $district_num = $district_rs->num_rows;

    for ($i = 0; $i < $district_num; $i++) {
        $district_data = $district_rs->fetch_assoc();

?>

        <option value="<?php echo $district_data["id"]; ?>"><?php echo $district_data["name"]; ?></option>

<?php
    }
}

?>