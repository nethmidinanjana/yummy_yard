<?php
session_start();
require "connection.php";

$email = $_SESSION["au"]["email"];

$pname = $_POST["pname"];
$description = $_POST["des"];
$category = $_POST["ca"];
$sub_category = $_POST["subca"];
$qty = $_POST["qty"];
$price = $_POST["price"];
$size = $_POST["size"];

// Validate input
if (empty($pname)) {
    die("Please enter product name!");
} else if (strlen($pname) >= 100) {
    die("Product name should have less than 100 characters!");
} else if (empty($description)) {
    die("Please enter product description!");
} else if ($category == "0") {
    die("Please select a category!");
} else if ($sub_category == "0") {
    die("Please select sub category!");
} else if (empty($qty) || !is_numeric($qty) || $qty <= 0) {
    die("Invalid value for field Quantity");
} else if (empty($price) || !is_numeric($price) || $price <= 0) {
    die("Invalid value for field Cost Per Item");
} else if ($size == "0") {
    die("Please select size!");
}

// Insert product
$result_product_insert = Database::iud("INSERT INTO foods (`name`,`description`,`date_time_added`,`delivery_fee`,`status_id`,`categories_id`,`sub_category_id`) VALUES ('$pname','$description',NOW(),'300','1','$category','$sub_category')");

if ($result_product_insert !== false) {
    $product_id = Database::$connection->insert_id;

    // Insert product details
    $result_details_insert = Database::iud("INSERT INTO food_details (`qty`,`price`,`size`,`foods_id`) 
                                           VALUES ('$qty','$price','$size','$product_id')");

    if ($result_details_insert !== false) {
        $details_id = Database::$connection->insert_id;

        // Define the upload directory relative to the project root
        $upload_directory = "../resources/product_images/";

        $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");
        $length = count($_FILES);

        for ($x = 0; $x < $length; $x++) {
            if (isset($_FILES["image" . $x])) {
                $image_file = $_FILES["image" . $x];
                $file_extension = $image_file["type"];

                // Check if the file type is allowed
                if (in_array($file_extension, $allowed_image_extensions)) {
                    $new_img_extension = pathinfo($image_file["name"], PATHINFO_EXTENSION);

                    // Construct the file name including the directory path
                    $file_name = $upload_directory . $pname . "_" . $x . "_" . uniqid() . ".$new_img_extension";

                    // Move uploaded file to destination
                    if (move_uploaded_file($image_file["tmp_name"], $file_name)) {
                        // Store only relative path in the database
                        $relative_file_path = "resources/product_images/" . basename($file_name);

                        // Insert into food_images table with relative path
                        $result_image_query = Database::iud("INSERT INTO `food_images`(`image_url`,`food_details_id`) 
                                          VALUES ('$relative_file_path','$details_id')");

                        if ($result_image_query !== false) {
                            echo "Image added successfully.";
                        } else {
                            echo "Error inserting image: " . Database::$connection->error;
                        }
                    } else {
                        echo "Failed to move uploaded file.";
                    }
                } else {
                    echo "Invalid image type";
                }
            }
        }


        echo "Product added successfully"; 
    } else {
        echo "Error inserting product details: " . Database::$connection->error;
    }
} else {
    echo "Error inserting product: " . Database::$connection->error;
}
