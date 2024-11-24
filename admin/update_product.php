<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_POST['update'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_NUMBER_INT);
    $name = $_POST['Item_Name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['Item_price'];
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = $_POST['Item_description'];
    
    // Using htmlspecialchars instead of filter_var to prevent truncation of certain characters
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $category = $_POST['Category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    // Update product details
    $update_product = $conn->prepare("UPDATE `menu` SET Category = ?, Item_Name = ?, Item_Price = ?, Item_Description = ? WHERE Item_id = ?");
    $update_product->bind_param("ssdsi", $category, $name, $price, $description, $pid);
    $update_product->execute();

    $message[] = 'Product updated!';

    $old_image = $_POST['old_image'];
    $image = $_FILES['Item_image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['Item_image']['size'];
    $image_tmp_name = $_FILES['Item_image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `menu` SET Item_Image = ? WHERE Item_id = ?");
            $update_image->bind_param("si", $image, $pid);
            $update_image->execute();
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/' . $old_image);
            $message[] = 'Image updated!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="../images/fast-food.png">
   <title>Update Product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">Update Product</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `menu` WHERE Item_id = ?");
      $show_products->bind_param("i", $update_id);
      $show_products->execute();
      $result = $show_products->get_result();

      if ($result->num_rows > 0) {
         while ($fetch_products = $result->fetch_assoc()) {
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['Item_id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['Item_Image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['Item_Image']; ?>" alt="">
      <span>Update Name</span>
      <input type="text" required placeholder="Enter product name" name="Item_Name" maxlength="100" class="box" value="<?= $fetch_products['Item_Name']; ?>">
      <span>Update Description</span>
      <textarea name="Item_description" maxlength="200" required class="box" placeholder="Enter product description"><?= $fetch_products['Item_Description']; ?></textarea>
      <span>Update Price</span>
      <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="Item_price" class="box" value="<?= $fetch_products['Item_Price']; ?>">
      <span>Update Category</span>
      <select name="Category" class="box" required>
         <option selected value="<?= $fetch_products['Category']; ?>"><?= $fetch_products['Category']; ?></option>
         <option value="Baskets & Hamburgers">Baskets & Hamburgers</option>
         <option value="Beverages">Beverages</option>
         <option value="Breakfast">Breakfast</option>
         <option value="Meal of Day">Meal Of Day</option>
         <option value="Rolls">Rolls</option>
         <option value="Sandwiches & Spheltho">Sandwiches</option>
      </select>
      <span>Update Image</span>
      <input type="file" name="Item_image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="Update" class="btn" name="update">
         <a href="products.php" class="option-btn">Go Back</a>
      </div>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">No products found!</p>';
      }

      $show_products->close();
   ?>

</section>

<!-- update product section ends -->

<!-- custom js file link  -->
<script src="admin_script.js"></script>

</body>
</html>
