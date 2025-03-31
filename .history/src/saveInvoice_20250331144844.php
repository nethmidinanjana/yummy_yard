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

if (isset($_SESSION["u"])) {
    if (!empty($_POST["o"]) && !empty($_POST["i"]) && !empty($_POST["u"]) && !empty($_POST["a"]) && isset($_POST["q"])) {
        $o_id = $_POST["o"];
        $p_id = $_POST["i"];
        $uid = $_POST["u"];
        $amount = $_POST["a"];
        $qty = (int)$_POST["q"]; // Convert quantity to integer

        $email = $_SESSION["u"]["email"];

        $product_rs = Database::search("SELECT * FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id WHERE food_details.foods_id = '" . $p_id . "' ");
        if ($product_rs->num_rows > 0) {
            $product_data = $product_rs->fetch_assoc();

            $curr_qty = (int)$product_data["qty"];
            $new_qty = $curr_qty - $qty;

            // Update quantity in food_details table
            Database::iud("UPDATE food_details SET qty = '" . $new_qty . "' WHERE foods_id = '" . $p_id . "'");

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            // Insert order details into invoice table
            Database::iud("INSERT INTO invoice (order_id, date_time, total, qty, status_id, foods_id, user_id) 
                           VALUES ('" . $o_id . "', '" . $date . "', '" . $amount . "', '" . $qty . "', '1', '" . $p_id . "', '" . $uid . "')");

            // Fetch product name for email content
            $product_name = $product_data["name"];

            // Send email with PHPMailer
            $mail = new PHPMailer;

            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $my_email; // Your Gmail username
            $mail->Password = 'radoastrhtnodvrx'; // Your Gmail password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('nethmidinanjana@gmail.com', 'Yummy Yard');
            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = 'Order Details for Order ID: ' . $o_id;

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
                        <p><strong>Order ID:</strong> ' . $o_id . '</p>
                        <p><strong>Product Name:</strong> ' . $product_name . '</p>
                        <p><strong>Quantity:</strong> ' . $qty . '</p>
                        <p><strong>Total Amount:</strong> LKR ' . $amount . '</p>
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
                echo 'Email sending failed.';
            } else {
                echo 'success';
            }
        } else {
            echo "Product not found.";
        }
    } else {
        echo "Invalid input data.";
    }
} else {
    echo "User session not found.";
}
?>
