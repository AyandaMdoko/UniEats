<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_POST['add_product'])) {

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);

    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    // Check if the directory exists and create if it doesn't
    if (!is_dir('../uploaded_img')) {
        mkdir('../uploaded_img', 0755, true);
    }

    // Check if product name already exists
    $stmt = $conn->prepare("SELECT * FROM `menu` WHERE Item_Name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $stmt = $conn->prepare("INSERT INTO `menu` (Item_Name, Item_Price, Item_Description, Category, Item_Image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sdsss", $name, $price, $description, $category, $image);
                $stmt->execute();
                $message[] = 'New product added!';
            } else {
                $message[] = 'Failed to upload image';
            }
        }
    }

    $stmt->close();
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    // Get the image to delete
    $stmt = $conn->prepare("SELECT Item_Image FROM `menu` WHERE Item_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->bind_result($image_to_delete);
    $stmt->fetch();
    unlink('../uploaded_img/' . $image_to_delete);
    $stmt->close();

    // Delete the product
    $stmt = $conn->prepare("DELETE FROM `menu` WHERE Item_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Optionally delete related items from the cart
    $stmt = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header('location:products.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="icon" href="../images/fast-food.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Product</h3>
      <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>Select category --</option>
         <option value="Baskets & Hamburgers">Baskets & Hamburgers</option>
         <option value="Beverages">Beverages</option>
         <option value="Breakfast">Breakfast</option>
         <option value="Meal of Day">Meal Of Day</option>
         <option value="Rolls">Rolls</option>
         <option value="Sandwiches & Spheltho">Sandwiches & Spheltho</option>
      </select>
      <textarea type="text" required placeholder="Enter product description" name="description" maxlength="500" class="box"> </textarea>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Add Product" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $stmt = $conn->prepare("SELECT * FROM `menu`");
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         while ($fetch_products = $result->fetch_assoc()) {
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['Item_Image']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>R</span><?= $fetch_products['Item_Price']; ?>.00<span>/-</span></div>
         <div class="category"><?= $fetch_products['Category']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['Item_Name']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['Item_id']; ?>" class="option-btn">Update</a>
         <a href="products.php?delete=<?= $fetch_products['Item_id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
      </div>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }

      $stmt->close();
   ?>

   </div>

</section>

<!-- show products section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>

</body>
</html>
