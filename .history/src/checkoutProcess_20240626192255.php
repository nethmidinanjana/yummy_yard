<?php
session_start();
require "connection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$response = [];

if (isset($_SESSION["u"])) {
    $user_id = $_SESSION["u"]["id"];

    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data["cartItems"])) {
        $order_id = uniqid(); // Generate a unique order ID
        $amount = 300;

        foreach ($data["cartItems"] as $item) {
            $product_id = $item["productId"];
            $quantity = (int)$item["quantity"];

            // Fetch product details
            $product_rs = Database::search("SELECT * FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id WHERE foods.id = '" . $product_id . "' ");
            if ($product_rs->num_rows > 0) {
                $product_data = $product_rs->fetch_assoc();
                $unit_price = (int)$product_data["price"];
                $subtotal = ($unit_price * $quantity);
                $amount += $subtotal;
            } else {
                $response = ["success" => false, "message" => "Product not found: " . $product_id];
                echo json_encode($response);
                exit;
            }
        }

        // Fetch user details
        $user_rs = Database::search("SELECT * FROM user INNER JOIN user_has_address ON user.id = user_has_address.user_id INNER JOIN city ON city.id = user_has_address.city_id WHERE user.id = '" . $user_id . "'");
        if ($user_rs->num_rows > 0) {
            $user_data = $user_rs->fetch_assoc();

            $merchant_id = "1221412";
            $merchant_secret = "MzQ0ODM5MDE0OTcwMDQ1ODc3ODEwNjgyMDAzNzgyNjc5MzE2ODgw";
            $currency = "LKR";

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
                "success" => true,
                "order_id" => $order_id,
                "total_amount" => $amount,
                "first_name" => $user_data["fname"],
                "last_name" => $user_data["lname"],
                "email" => $user_data["email"],
                "phone" => $user_data["contact_num"],
                "address" => $user_data["line1"] . " " . $user_data["line2"],
                "city" => $user_data["name"],
                "items" => "Basket Checkout",
                "currency" => $currency,
                "hash" => $hash
            ];
        } else {
            $response = ["success" => false, "message" => "User details not found"];
        }
    } else {
        $response = ["success" => false, "message" => "No items in cart"];
    }
} else {
    $response = ["success" => false, "message" => "User not logged in"];
}

echo json_encode($response);
?>
