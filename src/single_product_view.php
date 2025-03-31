<?php
include "header.php";

if (isset($_GET["id"])) {

    $pid = $_GET["id"];

    $product_rs = Database::search("SELECT foods.id AS food_id, foods.name AS food_name, food_details.id AS food_details_id, sub_category.id AS sub_category_id, sub_category.name AS sub_category_name, categories.name AS category_name, foods.*, food_details.*, sub_category.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id INNER JOIN categories ON foods.categories_id = categories.id INNER JOIN sub_category ON  foods.sub_category_id = sub_category.id WHERE foods.id = '" . $pid . "'");

    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {
        $product_data = $product_rs->fetch_assoc();

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Yummy Yard</title>
            <link rel="icon" href="../resources/logo.svg" />

            <link rel="stylesheet" href="output.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="input.css">
            <!-- Include Tailwind CSS -->
            <link href="https://cdn.tailwindcss.com" rel="stylesheet">

            <script src="https://cdn.tailwindcss.com"></script>
        </head>

        <body>
            <div class="w-full flex flex-col h-auto justify-center items-center">

                <div class="w-full h-auto flex justify-center items-center">
                    <div class="div-width flex flex-wrap signleViewFLexDiv justify-center items-  px-9 py-9">
                        <div class="inner-div-width flex justify-center items-center">
                            <div class="div-width flex flex-col justify-center items-center">

                                <?php
                                $image_rs = Database::search("SELECT * FROM food_images WHERE food_images.food_details_id = '" . $product_data["food_details_id"] . "'");

                                $image_urls = [];

                                while ($image_row = $image_rs->fetch_assoc()) {
                                    $image_urls[] = $image_row["image_url"];
                                }

                                $default_image_url = "resources/food_grey_restaurant_icon.png";

                                while (count($image_urls) < 3) {
                                    $image_urls[] = $default_image_url;
                                }
                                ?>

                                <div class="object-cover w-full ">
                                    <img src="../<?php echo $image_urls[0]; ?>" alt="Product Image" class="object-cover w-full">
                                </div>
                                <div class="flex gap-5 flex-wrap justify-between items-between  mt-3">
                                    <img src="../<?php echo $image_urls[1]; ?>" alt="Product Image" class="w-[270px] h-[190px]">
                                    <img src="../<?php echo $image_urls[2]; ?>" alt="Product Image" class="w-[270px] h-[190px]">
                                </div>

                            </div>
                        </div>
                        <div class="inner-div-width border rounded-lg px-12 py-12 border-black bg-white">
                            <span class="rajdhani-light text-2xl font-semibold"><?php echo $product_data["food_name"] ?></span><br>
                            <div class="mt-6">
                                <label>Reviews</label>
                            </div>
                            <div class="flex gap-2 mt-2 flex-wrap">
                                <img src="../resources/start-full.svg" alt="Yello Star">
                                <img src="../resources/start-full.svg" alt="Yello Star">
                                <img src="../resources/start-full.svg" alt="Yello Star">
                                <img src="../resources/start-full.svg" alt="Yello Star">
                                <img src="../resources/start-empty.svg" alt="Yello Star">
                            </div>
                            <p class="rajdhani-light mt-5 mb-3 font-medium">
                                <?php echo $product_data["description"] ?>
                            </p>
                            <div>
                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Delivery is only available around Colombo.</span>
                            </div>

                            <div class="mt-5">
                                <div class="flex items-center gap-4 flex-wrap" style="margin-top: 20px; margin-bottom:20px;">


                                    <div class=" bg-gray-700 rounded-xl text-white flex justify-center items-center px-6 py-3"><span class="rajdhani-light font-semibold">
                                            <?php
                                            switch ($product_data["size"]) {
                                                case "S":
                                                    echo "Small";
                                                    break;
                                                case "M":
                                                    echo "Medium";
                                                    break;
                                                case "L":
                                                    echo "Large";
                                                    break;
                                                case "R":
                                                    echo "Regular";
                                                    break;
                                                default:
                                                    echo "Unknown Size";
                                                    break;
                                            }
                                            ?>
                                        </span></div>
                                    <div class="flex  border rounded-lg px-5 py-2 bg-orange-600">
                                        <span class="rajdhani-light text-xl font-semibold text-white">Rs. <?php echo $product_data["price"] ?>. 00 Only</span><br>
                                    </div>

                                </div>
                            </div>


                            <div class="mt-7 flex flex-col gap-4">

                                <span class="rajdhani-light text-lg font-medium">Available Quantity</span>
                                <div>
                                    <span class="bg-yellow-100 text-yellow-800 text-lg font-medium me-2 px-8 py-2 rounded dark:bg-yellow-900 dark:text-yellow-300"><?php
                                                                                                                                                                    if ($product_data["qty"] == 0) {
                                                                                                                                                                        echo ("Not available");
                                                                                                                                                                    } else {
                                                                                                                                                                        echo ($product_data["qty"]);
                                                                                                                                                                    } ?></span>
                                </div>

                            </div>

                            <div class="mt-9 flex flex-wrap gap-6">
                                <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900" onclick="openModal(<?php echo $product_data['food_id']; ?>)">
                                    <span class="rajdhani-light text-2xl font-medium">Order Now</span>
                                </button>
                                <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" data-product-id="<?php echo $pid; ?>" onclick="openABModal(this);">
                                    <span class="rajdhani-light text-2xl font-medium">Add to Basket</span>
                                </button>
                            </div>


                            <!-- Modal -->
                            <div class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" id="addToBasketModal-<?php echo $pid; ?>">
                                <div class="modal-content bg-white p-6 rounded-lg">
                                    <div class="modal-body">
                                        <form>
                                            <div class="flex flex-col w-full">
                                                <label for="product-qty-<?php echo $pid; ?>">Insert Quantity</label>
                                                <input type="number" id="product-qty-<?php echo $pid; ?>" class="w-full border border-gray-300 rounded px-2 py-1 mb-4" min="1" value="1">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded ml-2" onclick="closeABModal(<?php echo $pid; ?>);">Close</button>
                                        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="addToBasket(<?php echo $pid; ?>);">Add To Basket</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order now Modal -->
                            <div id="orderModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
                                <div class="bg-white rounded-lg p-6 w-1/3">
                                    <div class="mb-4">
                                        <label for="quantity" class="block text-sm font-medium text-gray-700">Enter Quantity</label>
                                        <input type="number" id="quantity" name="quantity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm mb-2" min="1" value="1">
                                        <span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300 ">Delivery charges: Rs. 300. 00</span>
                                    </div>
                                    <button id="modalOrderNowBtn" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900" onclick="orderNow(<?php echo $product_data['food_id']; ?>)">
                                        Order Now
                                    </button>
                                    <button class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500" onclick="closeModal()">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="w-full h-auto border mt-3 mb-3">
                            <hr>
                        </div>

                        <!-- Related foods -->
                        <div class="inner-div-width flex px-3">
                            <div class="div-width flex flex-col border rounded-lg px-7 py-5 mt-4 border-gray-400">
                                <span class="rajdhani-light text-xl font-semibold">Other Related Products</span>

                                <div class="flex w-full flex-wrap mt-2 gap-3">

                                    <?php

                                    $rp_rs = Database::search("SELECT food_details.id AS food_details_id, foods.*, food_details.* FROM foods INNER JOIN food_details ON foods.id = food_details.foods_id WHERE foods.sub_category_id = '" . $product_data["sub_category_id"] . "' AND foods.id != '" . $pid . "'  LIMIT 2");

                                    $rp_num = $rp_rs->num_rows;

                                    if ($rp_num != 0) {
                                        for ($i = 0; $i < $rp_num; $i++) {
                                            $rp_data = $rp_rs->fetch_assoc();
                                    ?>

                                            <div class="w-full  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" style="width: 230px;">

                                                <a href="#">

                                                    <?php

                                                    $img_rs = Database::search("SELECT id, image_url, food_details_id FROM (SELECT id,image_url,food_details_id, ROW_NUMBER() OVER (PARTITION BY food_details_id ORDER BY id) AS row_num FROM food_images WHERE food_details_id = '" . $rp_data["food_details_id"] . "') AS RankedFoodImages WHERE row_num = 1 ");

                                                    $img_num = $img_rs->num_rows;

                                                    if ($img_num == 1) {
                                                        $img_data = $img_rs->fetch_assoc();

                                                    ?>

                                                        <img class="p-8 rounded-t-lg" src="../<?php echo $img_data["image_url"] ?>" alt="product image" />

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img class="p-8 rounded-t-lg" src="../resources/food_grey_restaurant_icon.png" alt="product image" />

                                                    <?php
                                                    }
                                                    ?>

                                                </a>
                                                <div class="px-5 pb-5">
                                                    <a href="#">
                                                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white"><?php echo $rp_data["name"] ?></h5>
                                                    </a>
                                                    <div class="flex items-center mt-2.5 mb-5">
                                                        <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                            <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                            <svg class="w-4 h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                        </div>
                                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-3">5.0</span>
                                                    </div>
                                                    <div class="flex flex-col items-center justify-between">
                                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">Rs. <?php echo $rp_data["price"] ?></span>
                                                        <a href="#" class="text-white mt-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add to cart</a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                    } else {
                                        ?>

                                        <h4 class="text-sm text-gray-500">No products yet</h4>

                                    <?php
                                    }

                                    ?>

                                </div>
                            </div>
                        </div>

                        <!-- Feedbacks -->
                        <div class="inner-div-width flex justify-center  border rounded-lg px-5 py-5 mt-4 border-gray-400">
                            <div class="div-width flex flex-col ">
                                <div class="mb-2">
                                    <span class="rajdhani-light text-xl font-semibold">Feedbacks</span>
                                </div>

                                <?php

                                $feedback_rs = Database::search("SELECT * FROM feedback INNER JOIN user ON feedback.user_id = user.id WHERE feedback.foods_id = '" . $pid . "'");

                                $feedback_num = $feedback_rs->num_rows;

                                if ($feedback_num == 0) {
                                ?>
                                    <h4 class="text-sm text-gray-500">No feedbacks yet</h4>
                                    <?php
                                } else {

                                    for ($j = 0; $j < $feedback_num; $j++) {
                                        $feedback_data = $feedback_rs->fetch_assoc();

                                    ?>
                                        <div class="flex flex-col border rounded-lg px-5 py-5 mt-3">
                                            <span class=" text-base text-yellow-600"><?php echo $feedback_data["fname"] ?></span>
                                            <p class="text-sm mt-3 text-gray-600"><?php echo $feedback_data["feedback"] ?></p>
                                        </div>
                                <?php
                                    }
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include "footer.php"; ?>
            <script src="../script.js"></script>
            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

        </body>

        </html>

<?php
    } else {
        echo ("Sorry for the Inconvenience");
    }
} else {
    echo ("Something went wrong");
}
?>