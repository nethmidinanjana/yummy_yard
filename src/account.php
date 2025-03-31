<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account</title>
    <link rel="stylesheet" href="output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="input.css">

    <link rel="icon" href="../resources/logo.svg" />
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="w-full flex flex-col">
        <?php

        include "header.php";

        if (isset($_SESSION["u"])) {

            $data = $_SESSION["u"];

        ?>

            <div class="w-full h-auto flex flex-wrap">
                <div class="flex flex-wrap  px-9 py-9">

                    <div class="side-div-width px-2 flex flex-col justify-start items-start">
                        <div class="flex w-full border rounded-lg border-gray-400 px-9 py-9 mt-3 flex-wrap bg-white justify-center items-center">
                            <div class="flex flex-wrap gap-3">
                                <span class="rajdhani-light text-3xl font-semibold">Your Profile</span>
                            </div>
                            <div class="flex flex-wrap w-full px-5 justify-center items-center mt-5">
                                <img src="../resources/fooddp.svg" alt="Poster Image">
                            </div>

                            <div class="flex flex-wrap w-full px-5 justify-center items-center mt-5">

                                <form class="w-full">
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                                            <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required value="<?php echo $data["fname"]; ?>" />
                                        </div>
                                        <div>
                                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                                            <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Doe" required value="<?php echo $data["lname"]; ?>" />
                                        </div>
                                        <div>
                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
                                            <input type="email" id="email" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@company.com" required value="<?php echo $data["email"]; ?>" disabled />
                                        </div>
                                        <div>
                                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone number</label>
                                            <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required value="<?php echo $data["contact_num"]; ?>" />
                                        </div>

                                        <?php

                                        $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON 
            user_has_address.city_id=city.id INNER JOIN `district` ON 
            city.district_id=district.id INNER JOIN `province` ON 
            district.province_id=province.id WHERE `user_id`= '" . $data["id"] . "' ");

                                        $address_data = $address_rs->fetch_assoc();
                                        ?>
                                        <div>
                                            <label for="address_line1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address line 1</label>
                                            <input type="test" id="address_line1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required <?php if (empty($address_data["line1"])) { ?> value="<?php echo ''; ?>" <?php } else { ?> value="<?php echo htmlspecialchars($address_data["line1"]); ?>" <?php } ?> />
                                        </div>
                                        <div>
                                            <label for="address_line2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address line 2</label>
                                            <input type="text" id="address_line2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required <?php if (empty($address_data["line2"])) { ?> value="<?php echo ''; ?>" <?php } else { ?> value="<?php echo htmlspecialchars($address_data["line2"]); ?>" <?php } ?> />
                                        </div>
                                        <div>
                                            <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>

                                            <form class="max-w-sm mx-auto">
                                                <select id="province" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="loadDistrict()">

                                                    <?php


                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                    $district_rs = Database::search("SELECT * FROM `district`");
                                                    $city_rs = Database::search("SELECT * FROM `city`");
                                                    $gender_rs = Database::search("SELECT * FROM `gender`");

                                                    ?>
                                                    <option selected value="0">Choose a Province</option>
                                                    <?php

                                                    $province_num = $province_rs->num_rows;
                                                    for ($x = 0; $x < $province_num; $x++) {
                                                        $province_data = $province_rs->fetch_assoc();

                                                    ?>
                                                        <option value="<?php echo $province_data["id"]; ?>" <?php

                                                                                                            if (!empty($address_data["province_id"])) {
                                                                                                                if ($province_data["id"] == $address_data["province_id"]) {
                                                                                                            ?>selected<?php
                                                                                                                    }
                                                                                                                }

                                                                                                                        ?>><?php echo $province_data["name"]; ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </form>

                                        </div>
                                        <div class="w-full">
                                            <label for="district" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">District</label>

                                            <form class="max-w-sm mx-auto w-full">
                                                <select id="district" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="loadCity()">
                                                    <option selected value="0">Choose a District</option>
                                                    <?php
                                                    $district_num = $district_rs->num_rows;
                                                    for ($x = 0; $x < $district_num; $x++) {
                                                        $district_data = $district_rs->fetch_assoc();

                                                    ?>

                                                        <option value="<?php echo $district_data["id"]; ?>" <?php
                                                                                                            if (!empty($address_data["district_id"])) {

                                                                                                                if ($district_data["id"] == $address_data["district_id"]) {
                                                                                                            ?>selected<?php

                                                                                                                    }
                                                                                                                }
                                                                                                                        ?>><?php echo $district_data["name"]; ?></option>

                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </form>

                                        </div>
                                        <div>
                                            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>

                                            <form class="max-w-sm mx-auto">
                                                <select id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option selected value="0">Choose a City</option>
                                                    <?php

                                                    $city_num = $city_rs->num_rows;
                                                    for ($x = 0; $x < $city_num; $x++) {
                                                        $city_data = $city_rs->fetch_assoc();

                                                    ?>
                                                        <option value="<?php echo $city_data["id"]; ?>" <?php

                                                                                                        if (!empty($address_data["city_id"])) {
                                                                                                            if ($city_data["id"] == $address_data["city_id"]) {
                                                                                                        ?>selected<?php
                                                                                                                }
                                                                                                            }

                                                                                                                    ?>><?php echo $city_data["name"]; ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </form>

                                        </div>
                                        <div>
                                            <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>

                                            <form class="max-w-sm mx-auto">
                                                <select id="gender" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?php if (!empty($data["gender_id"])) {
                                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                                    } ?>>
                                                    <?php

                                                    $gender_num = $gender_rs->num_rows;
                                                    for ($x = 0; $x < $gender_num; $x++) {
                                                        $gender_data = $gender_rs->fetch_assoc();

                                                    ?>
                                                        <option value="<?php echo $gender_data["id"]; ?>" <?php

                                                                                                            if (!empty($data["gender_id"])) {
                                                                                                                if ($gender_data["id"] == $data["gender_id"]) {
                                                                                                            ?>selected<?php
                                                                                                                    }
                                                                                                                }

                                                                                                                        ?>><?php echo $gender_data["name"]; ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </form>

                                        </div>
                                    </div>

                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="updateProfile();">Update Profile</button>
                                </form>

                            </div>


                        </div>

                    </div>
                    <div class="orders-div-width border rounded-lg border-gray-400 px-9 py-9 flex flex-col flex-wrap justify- items-center bg-white mt-3">
                        <span class="rajdhani-light text-3xl font-semibold">Your Orders</span>

                        <?php
                        $order_rs =  Database::search("SELECT invoice.qty AS order_qty, invoice.status_id AS invoice_status, invoice.*,food_details.id AS food_details_id, food_details.*, foods.* FROM invoice INNER JOIN foods ON invoice.foods_id = foods.id INNER JOIN food_details ON foods.id = food_details.foods_id WHERE invoice.user_id = '" . $_SESSION["u"]["id"] . "' AND invoice.status_id != 2 ORDER BY invoice.date_time DESC ");
                        $order_num = $order_rs->num_rows;

                        if ($order_num > 0) {
                            for ($i = 0; $i < $order_num; $i++) {
                                $order_data = $order_rs->fetch_assoc();

                                $food_img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $order_data["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                                $food_data = $food_img_rs->fetch_assoc();

                        ?>
                                <div class="flex w-full border rounded-lg border-gray-400 px-5 py-5 mt-5 flex-wrap">
                                    <div class="min-width px-2 flex justify-center items-center">
                                        <img src="../<?php echo $food_data["image_url"] ?>" alt="Order Image" class="rounded-sm">
                                    </div>
                                    <div class="middle-box-width px-8 flex flex-col justify-center">
                                        <span class="rajdhani-light text-sm text-gray-500">Order Id : <?php echo $order_data["order_id"] ?></span>
                                        <span class="rajdhani-light text-xl font-semibold"><?php echo $order_data["name"] ?></span>
                                        <span class="rajdhani-light text-lg font-medium">Rs. <?php echo $order_data["total"] ?>.00</span>
                                        <div class="flex w-full items-center gap-4 mt-1 center">
                                            <div class="flex items-center justify-center gap-4">
                                                <div class=" bg-gray-800 rounded-xl text-white flex justify-center items-center" style="width: 41px; height: 41px;"><span class="rajdhani-light font-semibold">M</span></div>
                                            </div>
                                            <div class="flex px-9 border rounded-lg justify-center items-center" style="height: 41px;">
                                                <span><?php echo $order_data["order_qty"] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="last-box-width flex flex-col justify-center items-center ">
                                        <div class="flex flex-wrap w-full px-8 gap-5">
                                            <div class="flex flex-col justify-center items-center">
                                                <div>
                                                    <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-9 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="openModal('<?php echo $order_data['foods_id']; ?>')">Add Feedback</button>
                                                </div>
                                                <?php
                                                $status_id = $order_data['invoice_status'];

                                                $status_text = '';
                                                $status_class = '';

                                                if ($status_id == 1) {
                                                    $status_text = 'Order processing';
                                                    $status_class = 'bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-300 border border-blue-300';
                                                } else if ($status_id == 3) {
                                                    $status_text = 'Order Confirmed';
                                                    $status_class = 'bg-green-100 text-green-900 dark:bg-green-800 dark:text-green-300 border border-green-400';
                                                } else if ($status_id == 4) {
                                                    $status_text = 'On Delivery';
                                                    $status_class = 'bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300';
                                                } else if ($status_id == 5) {
                                                    $status_text = 'Order Delivered';
                                                    $status_class = 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300 border border-red-300';
                                                } else {
                                                    $status_text = 'Unknown status';
                                                    $status_class = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-300';
                                                }
                                                ?>

                                                <div class="mt-4">
                                                    <span class="<?php echo $status_class; ?> text-md font-medium me-2 px-5 py-2.5 rounded-lg"><?php echo $status_text; ?></span>
                                                </div>


                                            </div>

                                            <div onclick="deleteOrder(<?php echo htmlspecialchars(json_encode($order_data['order_id']), ENT_QUOTES, 'UTF-8'); ?>);">
                                                <img src="../resources/delete.svg" alt="Delete icon" class="w-6">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div id="feedbackModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md">
                                        <!-- Modal header -->
                                        <div class="flex justify-between items-center mb-4">
                                            <h2 class="text-xl font-semibold">Add Feedback</h2>
                                            <button class="text-gray-500 hover:text-gray-700 focus:outline-none" onclick="closeModal()">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Modal body -->
                                        <div id="feedbackForm">
                                            <div class="mb-4">
                                                <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                                                <textarea id="feedback" name="feedback" rows="3" class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                            </div>

                                            <!-- Hidden input for food id -->
                                            <input type="hidden" id="foodId" name="foodId" value="">

                                            <!-- Submit button -->
                                            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-9 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="addFeedback()">
                                                Add Feedback
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } else {
                            ?>
                            <div class="w-full flex justify-center items-center mt-6">
                                <span class="bg-red-100 text-red-800 text-md font-medium me-2 px-5 py-2.5 rounded dark:bg-red-900 dark:text-red-300">You have not placed any orders yet!</span>
                            </div>
                        <?php
                        }
                        ?>



                        <div class="flex w-full justify-center items-center mt-9">
                            <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900" onclick="scrollToAllFoods();"><span class="rajdhani-light text-lg font-semibold">Explore Foods</span></button>
                        </div>

                    </div>




                </div>
            </div>


    </div>
    </div>

    <?php include "footer.php"; ?>

<?php

        } else {
?>
    <div class="w-full h-full flex flex-col">
        <div class="w-full h-auto flex flex-col justify-center items-center mt-5 mb-5">
            <img src="../resources/fooddp.svg" alt="Food Basket" class="w-40 mb-5 mt-5">
            <span class="rajdhani-light text-2xl font-semibold">You need to sign up to use the profile !</span>
            <button class="relative inline-flex items-center justify-center p-0.5 mt-4 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 group-hover:from-red-200 group-hover:via-red-300 group-hover:to-yellow-200 dark:text-white dark:hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400" onclick="navigateToSignUp();">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0 rajdhani-light text-xl font-semibold">
                    Sign Up
                </span>
            </button>
        </div>
        <?php include "footer.php"; ?>
    </div>


<?php
        }


?>
<script src="../script.js"></script>
</body>

</html>