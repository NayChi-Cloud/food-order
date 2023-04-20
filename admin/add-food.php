<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <br />
        <h1>Add Food</h1>
        <br /><br />
    <?php 
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
       }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td><input type="text" name="title" placeholder="Title of the Food"/>
            </td>
            </tr>
            <tr>
                <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of food"></textarea>
                    </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td><input type="number" name="price" >
              </tr>

              <tr>
                <td>Selcet Image:</td> 
                <td><input type="file" name="image" >
              </tr>

            <tr>
                <td>Category:</td>
                <td>
                    <select name="category" >
                        <?php 
                            //Create Php code to display categories from database
                            //1.Create SQL to get all Active categories
                            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                            $res = mysqli_query($conn,$sql);

                            $count = mysqli_num_rows($res);
                            //if count is greater than zero, we habe categories 
                            if($count>0){
                                //we have categories
                                while($row=mysqli_fetch_assoc($res)){
                                //get the details of categories
                                $id = $row['id'];
                                $title = $row['title'];
                                    ?>
                                 <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                            }
                         }else{
                            //We don't categories
                            ?>
                            <option value="0">No Categories found</option>
                            <?php
                         }
                        ?>

                    </select>
                </td>
            </tr>

              <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" name="featured" value="Yes"/>Yes
                    <input type="radio" name="featured" value="No"/>No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td><input type="radio" name="active" value="Yes"/>Yes
                    <input type="radio" name="active" value="No"/>No
            </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
         </table>
        </form>
                <?php
                if(isset($_POST['submit'])){
                    //add thefood in DB
                    //1. Get the data from form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                        //checck radio button is clicked for featured and active

                    if(isset($_POST['featured'])){
                        $featured = $_POST['featured'];
                    }else{
                        $featured = "No"; //setting the default value
                    }

                    if(isset($_POST['active'])){
                        $active = $_POST['active'];
                    }else{
                        $active = "No";
                    }

                    //2.Upload image if selected
                    if(isset($_FILES['image']['name'])){
                        $image_name = $_FILES['image']['name'];
                         
                        if($image_name!=""){
                            //imge is selected
                            //A.rename the image
                        //Get the extension
                        $ext = end(explode('.',$image_name));

                        $image_name = "food-Name".rand(0000,9999).".".$ext;
                            //B.Upload the img

                        //Get the source path and distination path
                        //source path = current location of image
                            $src = $_FILES['image']['tmp_name'];
                        //Destination path
                            $dst = "../images/food/".$image_name;
                            
                            $upload = move_uploaded_file($src,$dst);
                            //check if image is  uploador not
                            if($upload==false){
                                $_SESSION['upload'] = "<div class ='error'>Failed to upload image.</div>";
                                header('location:'.SITEURL.'admin/add-food.php');

                                die();
                            }
                        }

                    }else{
                        $image_name = "";
                    }
                    //3.Insert to database
                        //for numerical value,we don't need single quote
                 $sql2= "INSERT INTO tbl_food SET
                    title='$title',
                    description = '$description',
                    price = $price,
                    image_name='$image_name',
                    category_id =$category, 
                    featured='$featured',
                    active= '$active' 
                    ";
                //Execute the Query
                $res2 = mysqli_query($conn,$sql2);
                //4.check whether the query is executed or not and data added or not
                if($res2==true){
                    //query added and food data Added
                    $_SESSION['add'] = "<div class='success'>
                     Added Food Successful.</div>";
                    //Redirect to Home page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }else{
                    //Failed to Add food
                    $_SESSION['add'] = "<div class='error text-center'>
                    Failed to add Food.</div>";
                    //Redirect to Home page
                    header('location:'.SITEURL.'admin/manage-food.php');
                    }
                
                    //4.redirect to the page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                
             ?>



    </div>
</div>





<?php include('partials/footer.php'); ?>