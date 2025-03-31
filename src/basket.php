<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket</title>
    <link rel="stylesheet" href="output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="input.css">

    <link rel="icon" href="../resources/logo.svg" />
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="w-full flex flex-col justify-center items-center">
        <?php

        include "header.php";


        if (isset($_SESSION["u"])) {
            $user_data = $_SESSION["u"];
            $uid = $user_data["id"];

            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_id`='" . $uid . "'");
            $cart_num = $cart_rs->num_rows;

            $total = 0;
            $subtotal = 0;
            $shipping = 0;

        ?>

            <div class="w-full h-auto flex flex-wrap">
                <div class="flex flex-wrap  px-9 py-9">
                    <div class="orders-div-width border rounded-lg border-gray-400 px-9 py-9 flex flex-col flex-wrap justify- items-center bg-white mt-3">
                        <?php
                        if ($cart_num != 0) {
                        ?>

                            <span class="rajdhani-light text-2xl font-semibold">You have <?php echo $cart_num; ?> item<?php if ($cart_num != 1) {
                                                                                                                            echo ("s");
                                                                                                                        } ?> in your Basket.</span>

                            <?php

                            for ($i = 0; $i < $cart_num; $i++) {
                                $cart_data = $cart_rs->fetch_assoc();

                                $product_rs = Database::search("SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, foods.*, food_details.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id WHERE foods.id = '" . $cart_data["foods_id"] . "'");

                                $product_data = $product_rs->fetch_assoc();

                                $qty = $cart_data["qty"];
                                $unit_price = $product_data["price"];
                                $ptotal = $qty * $unit_price;

                                $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $product_data["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                                $food_data = $food_img_rs->fetch_assoc();

                                $total = $total + ($product_data["price"] * $cart_data["qty"]);

                            ?>

                                <div class="flex w-full border rounded-lg border-gray-400 px-5 py-5 mt-5 flex-wrap cart-item" data-product-id="<?php echo $product_data["food_id"]; ?>">
                                    <a class="min-width px-2 flex justify-center items-center" href='<?php echo "single_product_view.php?id=" . $product_data["food_id"]; ?>'>
                                        <img src="../<?php echo $food_data["image_url"] ?>" alt="Order Image" class="rounded-sm">
                                    </a>
                                    <div class="middle-box-width px-8 flex flex-col justify-center">
                                        <span class="rajdhani-light text-xl font-medium"><?php echo $product_data["food_name"] ?></span>

                                        <div class="mt-2">
                                            <span class="rajdhani-light text-sm font-semi mt-2 bg-blue-100 text-blue-800 me-2 px-5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 product-quantity"><?php echo $cart_data["qty"]; ?></span>

                                        </div>
                                        <span class="rajdhani-light text-lg font-medium mt-2">Rs. <?php echo $ptotal; ?>.00</span>

                                    </div>
                                    <div class="last-box-width flex flex-col justify-center items-center">
                                        <div>
                                            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-14 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="deleteFromCart(<?php echo $cart_data['id']; ?>);">Remove</button>
                                        </div>
                                        <div class="mt-4">
                                            <a type="button" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-14 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900" href='<?php echo "single_product_view.php?id=" . $product_data["food_id"]; ?>'>Buy Now</a>
                                        </div>
                                    </div>
                                </div>



                            <?php
                            }

                            ?>



                            <div class="flex w-full justify-center items-center mt-9">
                                <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900" onclick="scrollToAllFoods();"><span class="rajdhani-light text-lg font-semibold">Explore Foods</span></button>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="flex flex-col justify-center items-center w-full gap-6 h-auto">
                                <img src="../resources/3973481.jpg" alt="Empty image" class="w-96 h-9w-96">
                                <span class="bg-red-100 text-red-800 text-xl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">You have nothing in your basket!</span>
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800" onclick="window.location.href='all_foods.php'">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Explore Foods
                                    </span>
                                </button>
                            </div>

                        <?php
                        }
                        ?>
                    </div>


                    <div class="side-div-width px-2 flex flex-col">
                        <div class="flex w-full border rounded-lg border-gray-400 px-9 py-9 mt-3 flex-wrap bg-white">
                            <span class="rajdhani-light text-2xl font-semibold">Summary</span>
                            <div class="flex flex-wrap w-full px-5 justify-between mt-5">
                                <span>Items (<?php echo ($cart_num); ?>) : </span>
                                <span>Rs. <?php echo ($total); ?>.00</span>
                            </div>
                            <div class="flex flex-wrap w-full px-5 justify-between mt-3">
                                <span>Delivery fee : </span>
                                <span>Rs. 300.00</span>
                            </div>
                            <div class="flex flex-wrap w-full px-5 justify-between mt-3">
                                <span>Total : </span>
                                <span>Rs. <?php echo ($total + 300); ?>.00</span>
                            </div>
                            <div class="flex w-full justify-center items-center mt-9">
                                <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-14 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="checkOut();">
                                    <span class="rajdhani-light text-lg font-semibold">Check Out</span>
                                </button>
                            </div>
                        </div>
                        <div class="flex w-full border rounded-lg border-gray-400 px-9 py-9 mt-5 flex-wrap bg-white">
                            <span class="rajdhani-light text-2xl font-semibold">Payment Methods</span>
                            <div class="flex flex-wrap w-full px-5 justify-between mt-5">
                                <img src="../resources/visa-logo.svg" alt="Visa Card Logo" class="mt-3" style="width: 120px;">
                                <img src="../resources/master-card-logo.svg" alt="Master Card Logo" class="mt-3" style="width: 120px;">
                            </div>
                            <div class="flex flex-wrap w-full px-5 justify-between mt-3">
                                <img src="../resources/paypal-logo.svg" alt="Paypal Logo" class="mt-3" style="width: 120px;">
                                <img src="../resources/payhere-logo.svg" alt="Payhere Logo" class="mt-3" style="width: 120px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div>
    <div class="w-full">

        <?php include "footer.php"; ?>
    </div>




<?php

        } else {
?>
    <div class="w-full h-full flex flex-col">
        <div class="w-full h-auto flex flex-col justify-center items-center mt-5 mb-5">
            <img src="../resources/9960462.jpg" alt="Food Basket" class="w-96">
            <span class="rajdhani-light text-2xl font-semibold">You need to sign up to use the basket !</span>
            <button class="relative inline-flex items-center justify-center p-0.5 mt-4 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 group-hover:from-red-200 group-hover:via-red-300 group-hover:to-yellow-200 dark:text-white dark:hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400" onclick="navigateToSignUp();">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0 rajdhani-light text-xl font-semibold">
                    Sign Up
                </span>
            </button>
        </div>
    </div>

    <?php include "footer.php"; ?>

<?php
        }


?>
<script src="../script.js"></script>
<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

</body>

</html>