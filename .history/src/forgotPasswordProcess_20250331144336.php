<?php

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$my_email = getenv('MY_EMAIL');
$gmail_app_pw = getenv('GMAIL_APP_PASSWORD');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "connection.php";
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_GET["e"])) {

    $email = $_GET["e"];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`= '" . $email . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {

        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        Database::iud("UPDATE `user` SET `verification_code`='" . $code . "' WHERE `email`='" . $email . "'");

        $mail = new PHPMailer;

        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nethmidinanjana@gmail.com';
        $mail->Password = 'radoastrhtnodvrx';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('nethmidinanjana@gmail.com', 'Yummy Yard');
        $mail->addAddress($email);
        $mail->isHTML(true);

        $mail->Subject = 'Forgot Password Verification Code: ' . $code;

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
                    <h1>Your Verification Code is <strong>' . $code . '</strong></h1>
                </div>
                <div class="footer">
                    <p>&copy; ' . date("Y") . ' Yummy Yard. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';

        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            echo 'Verification code sending failed.';
        } else {
            echo 'success';
        }
    } else {
        echo ("Invalid Email Address !!!");
    }
}
