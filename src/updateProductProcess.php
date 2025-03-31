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
$pid = $_POST["pid"];
$fdid = $_POST["fdid"];

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

// Update product
$result_product_update = Database::iud("UPDATE foods SET `name` = '" . $pname . "', `description` = '" . $description . "', `categories_id` = '" . $category . "', `sub_category_id` = '" . $sub_category . "' WHERE `id` = '" . $pid . "'");

if ($result_product_update !== false) {
    // Update product details
    $result_details_update = Database::iud("UPDATE food_details SET `qty` = '" . $qty . "', `price` = '" . $price . "', `size` = '" . $size . "' WHERE `foods_id` = '" . $pid . "' ");

    if ($result_details_update !== false) {
        $upload_directory = "../resources/product_images/";
        $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");
        $length = count($_FILES);

        // Collect existing image records for the given food_details_id
        $img_rs = Database::search("SELECT id FROM food_images WHERE food_details_id = '" . $fdid . "'");
        $existing_images = array();
        while ($row = $img_rs->fetch_assoc()) {
            $existing_images[] = $row['id'];
        }

        if ($length <= count($existing_images)) {
            // Update the existing image records
            for ($x = 0; $x < $length; $x++) {
                if (isset($_FILES["image" . $x])) {
                    $image_file = $_FILES["image" . $x];
                    $file_extension = $image_file["type"];

                    if (in_array($file_extension, $allowed_image_extensions)) {
                        $new_img_extension = pathinfo($image_file["name"], PATHINFO_EXTENSION);
                        $file_name = $upload_directory . $pname . "_" . $x . "_" . uniqid() . ".$new_img_extension";
                        $relative_file_path = "resources/product_images/" . basename($file_name);

                        if (move_uploaded_file($image_file["tmp_name"], $file_name)) {
                            // Update the image URL in the database for the given food_details_id
                            $result_image_query = Database::iud("UPDATE `food_images` SET `image_url` = '" . $relative_file_path . "' WHERE `id` = '" . $existing_images[$x] . "'");
                            if ($result_image_query === false) {
                                echo "Error updating image URL in the database: " . Database::$connection->error;
                            }
                        } else {
                            echo "Failed to move uploaded file.";
                        }
                    } else {
                        echo "Invalid image type.";
                    }
                }
            }
            echo "Product updated successfully.";
        } else {
            echo "The number of uploaded images exceeds the number of existing images.";
        }
    } else {
        echo "Error updating product details: " . Database::$connection->error;
    }
} else {
    echo "Error updating product: " . Database::$connection->error;
}
?>
