<?php
 include('../config/constants.php');

 //check whether the id and image value is set or not
 if(isset($_GET['id']) AND isset($_GET['image_name']))
 {
   $id = $_GET['id'];
   $image_name = $_GET['image_name'];

   //remove the pysical image file is avaliable
   if($image_name != ""){

    //Image is avaliable so Remove it
    $path = "../images/category/".$image_name;

    $remove = unlink($path);

    //If Fail to remove,show error mes
    if($remove==false){
        $_SESSION['remove'] = "<div class='error'>Failed to remove Category</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
        die();
        }
   }

   //Delete data from database
   $sql = "DELETE FROM tbl_category WHERE id= $id";
   //Execute the query
   $res = mysqli_query($conn,$sql);

   if($res==true){

    $_SESSION['delete'] = "<div class='success'>
    Category Deleted Successfully.</div>";
    header('location:'.SITEURL.'admin/manage-category.php');
    }
else{

    //Set failed message
    $_SESSION['delete'] = "<div class='error'>
    Fail to delete category.</div>";
    header('location:'.SITEURL.'admin/manage-category.php');
    }
 }
 else{

 //redirect to manage category page
     header('location:'.SITEURL.'admin/manage-category.php');
 }

        ?>