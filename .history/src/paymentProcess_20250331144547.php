<?php

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$merchant_id = getenv('MERCHANT_ID');
$merchant_secret = getenv('MERCHANT_SECRET');

session_start();
require "connection.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$response = [];

try {
    if (isset($_SESSION["u"])) {
        $pid = $_POST["pid"];
        $qty = $_POST["qty"];
        $uid = $_SESSION["u"]["id"];

        $product_rs = Database::search("SELECT * FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id WHERE foods.id = '" . $pid . "'");

        if ($product_rs->num_rows == 1) {
            $product_data = $product_rs->fetch_assoc();

            $pqty = $product_data["qty"];

            if ($qty <= $pqty) {

                $user_rs = Database::search("SELECT * FROM user INNER JOIN user_has_address ON user.id = user_has_address.user_id INNER JOIN city ON city.id = user_has_address.city_id WHERE user.id = '" . $uid . "'");

                $user_num = $user_rs->num_rows;

                if ($user_num == 1) {

                    $user_data = $user_rs->fetch_assoc();
                    $fname = $user_data['fname'];
                    $lname = $user_data['lname'];
                    $email = $user_data['email'];
                    $phone = $user_data['contact_num'];
                    $address = $user_data['line1']." ".$user_data['line2'];
                    $city = $user_data['name'];

                    $amount = $product_data["price"] * $qty + 300;
                    $merchant_id = $merchant_id;
                    $order_id = uniqid();
                    $merchant_secret = $merchant_secret;
                    $currency = "LKR";
                    $item = $product_data["name"];

                    $hash = strtoupper(
                        md5(
                            $merchant_id .
                                $order_id .
                                number_format($amount, 2, '.', '') .
                                $currency .
                                strtoupper(md5($merchant_secret))
                        )
                    );

                    $response = [
                        "amount" => $amount,
                        "merchant_id" => $merchant_id,
                        "order_id" => $order_id,
                        "currency" => $currency,
                        "hash" => $hash,
                        "fname" => $fname,
                        "lname" => $lname,
                        "email" => $email,
                        "phone" => $phone,
                        "address" => $address,
                        "city" => $city,
                        "item" => $item,
                        "uid" => $uid
                    ];
                } else {
                    $response["error"] = "Please update your profile entering your address data before ordering.";
                }
            } else {
                $response["error"] = "Unavailable quantity. We only have " . $pqty . " in the stock.";
            }
        } else {
            $response["error"] = "Product not found.";
        }
    } else {
        $response["error"] = "Please login first.";
    }

    echo json_encode($response);
} catch (Exception $e) {
    $response["error"] = "An unexpected error occurred.";
    echo json_encode($response);
    error_log($e->getMessage());
    exit();
}

exit();
