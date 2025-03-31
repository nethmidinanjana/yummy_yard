<?php

require "connection.php";

if (isset($_GET["d"])) {

    $district_id = $_GET["d"];

    $city_rs = Database::search("SELECT * FROM `city` WHERE `district_id`= '" . $district_id . "' ");
    $city_num = $city_rs->num_rows;

    for ($i = 0; $i < $city_num; $i++) {
        $city_data = $city_rs->fetch_assoc();

?>

        <option value="<?php echo $city_data["id"]; ?>"><?php echo $city_data["name"]; ?></option>

<?php
    }
}

?>