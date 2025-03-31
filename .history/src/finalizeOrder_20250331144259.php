<?php

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$my_email = getenv('MY_EMAIL');
$gmail_app_pw = getenv('GMAIL_APP_PASSWORD');

session_start();
require "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

header('Content-Type: application/json');

if (isset($_SESSION["u"])) {
    $user_id = $_SESSION["u"]["id"];
    $email = $_SESSION["u"]["email"];

    $data = json_decode(file_get_contents('php://input'), true);
    $order_id = $data["order_id"];

    // Fetch cart items again (to double-check quantities)
    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_id`='" . $user_id . "'");
    $cart_num = $cart_rs->num_rows;

    if ($cart_num > 0) {
        $total_amount = 0;
        $order_details = [];

        while ($cart_data = $cart_rs->fetch_assoc()) {
            $product_id = $cart_data["foods_id"];
            $quantity = $cart_data["qty"];

            // Fetch product details
            $product_rs = Database::search("SELECT * FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id WHERE foods.id = '" . $product_id . "' ");
            if ($product_rs->num_rows > 0) {
                $product_data = $product_rs->fetch_assoc();
                $unit_price = (int)$product_data["price"];
                $subtotal = $unit_price * $quantity;
                $total_amount += $subtotal;

                // Update product quantity in the database
                $current_qty = (int)$product_data["qty"];
                $new_qty = $current_qty - $quantity;
                Database::iud("UPDATE food_details SET qty = '" . $new_qty . "' WHERE foods_id = '" . $product_id . "'");

                // Insert order details into the invoice table
                $d = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $d->setTimezone($tz);
                $date = $d->format("Y-m-d H:i:s");

                Database::iud("INSERT INTO invoice (order_id, date_time, total, qty, status_id, foods_id, user_id) 
                               VALUES ('" . $order_id . "', '" . $date . "', '" . $subtotal . "', '" . $quantity . "', '1', '" . $product_id . "', '" . $user_id . "')");

                $order_details[] = [
                    'product_name' => $product_data["name"],
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            } else {
                echo json_encode(["success" => false, "message" => "Product not found: " . $product_id]);
                exit;
            }
        }

        // Clear the user's cart
        Database::iud("DELETE FROM cart WHERE user_id = '" . $user_id . "'");

        // Send email with PHPMailer
        $mail = new PHPMailer;

        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $my_email; // Your Gmail username
        $mail->Password = $gmail_app_pw; // Your Gmail password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($my_email, 'Yummy Yard');
        $mail->addAddress($email);
        $mail->isHTML(true);

        $mail->Subject = 'Order Details for Order ID: ' . $order_id;

        // Construct email body
        $bodyContent = '
        <html>
        <head>
            <style>
                .container {
                    font-family: Arial, sans-serif;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #e0e0e0;
                    border-radius: 10px;
                    background-color: #f9f9f9;
                }
                .header {
                    text-align: center;
                    padding: 10px;
                    background-color: #007BFF;
                    color: #ffffff;
                    border-top-left-radius: 10px;
                    border-top-right-radius: 10px;
                }
                .content {
                    padding: 20px;
                    text-align: center;
                }
                .content h1 {
                    color: #333333;
                }
                .table {
                    width: 100%;
                    margin-top: 20px;
                    border-collapse: collapse;
                }
                .table th, .table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                .table th {
                    background-color: #f2f2f2;
                    text-align: left;
                }
                .footer {
                    text-align: center;
                    padding: 10px;
                    font-size: 12px;
                    color: #888888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Yummy Yard</h2>
                </div>
                <div class="content">
                    <h1>Your Order Details</h1>
                    <p><strong>Order ID:</strong> ' . $order_id . '</p>
                    <table class="table">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>';

        foreach ($order_details as $detail) {
            $bodyContent .= '
                        <tr>
                            <td>' . $detail['product_name'] . '</td>
                            <td>' . $detail['quantity'] . '</td>
                            <td>LKR ' . $detail['subtotal'] . '</td>
                        </tr>';
        }

        $bodyContent .= '
                        <tr>
                            <td colspan="2"><strong>Total Amount</strong></td>
                            <td><strong>LKR ' . $total_amount . '</strong></td>
                        </tr>
                    </table>
                    <p><strong>Order Date:</strong> ' . $date . '</p>
                </div>
                <div class="footer">
                    <p>&copy; ' . date("Y") . ' Yummy Yard. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';

        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            echo json_encode(["success" => false, "message" => 'Email sending failed.']);
        } else {
            echo json_encode(["success" => true, "message" => 'Order finalized successfully and email sent!']);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Cart is empty"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
}
?>
