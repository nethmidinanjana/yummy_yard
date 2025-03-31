<?php

require "connection.php";

if(isset($_GET["id"])){
    $oid = $_GET["id"];

    $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='".$oid."'");
    $invoice_data = $invoice_rs->fetch_assoc();

    $status_id = $invoice_data["status_id"];
    $new_status = 0;

    if($status_id == 1){
        Database::iud("UPDATE `invoice` SET `status_id`='3' WHERE `order_id`='".$oid."'");
        $new_status = 3;
    }else if($status_id == 3){
        Database::iud("UPDATE `invoice` SET `status_id`='4' WHERE `order_id`='".$oid."'");
        $new_status = 4;
    }else if($status_id == 4){
        Database::iud("UPDATE `invoice` SET `status_id`='5' WHERE `order_id`='".$oid."'");
        $new_status = 5;
    }else if($status_id == 5){
        Database::iud("UPDATE `invoice` SET `status_id`='2' WHERE `order_id`='".$oid."'");
        $new_status = 2;
    }

    echo $new_status;

}

?>