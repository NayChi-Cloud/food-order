<?php include('partials/menu.php');?>
<?php
//check whether id is set or not
if(isset($_GET['id'])){
    $id = $_GET['id'];

    //SQL to get seleted food
    $sql2 = "SELECT * FROM tbl_food WHERE id= $id";
          
    //Execute Query
    $res2= mysqli_query($conn,$sql2);

    //get the value baased on query execcuted
    $row2 = mysqli_fetch_assoc($res2);

    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
}
else{
    header('location:'.SITEURL.'admin/manage-food.php');
}
    ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action = "" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value = "<?php echo $title; ?>"/>
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name = "description" cols="30" rows = "5"><?php echo $description;?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value ="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image == ""){
                                //image not avaliable
                                echo "<div class='error'>Image Not Avaliable.</div>";
                            }else{
                                //image Avaliable
                                ?>
                                <img src ="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>Selected New Image</td>
                    <td>
                        <input type="file" name="image" />
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                        <?php
                            //query
                            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                              //Execute Query
                            $res= mysqli_query($conn,$sql);

                            //Count the row to check id is valid or nor
                            $count = mysqli_num_rows($res);

                                if($count > 0){
                                    while ($row=mysqli_fetch_assoc($res)){
                                        $category_title = $row['title'];
                                        $category_id =$row['id'];
                                      ?>
                                      <option <?php if($current_category==$category_id){echo "Selected";} ?>
                                       value="<?php echo $category_id; ?>"><?php echo $category_title; ?>
                                      <?php
                                    }
                           
                                }else{
                                    echo "<option value='0'>Category Not Avaliable.</option>";
                                }
                            ?>


                           
                        </select>
                    </td>
                </tr>


                <tr>
                <td>Featured:</td>
                <td>
                <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"/>Yes
                <input <?php if($featured == "No"){echo "checked";} ?>type="radio" name="featured" value="No"/>No
            </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"/>Yes
                <input  <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No"/>No
            </td>
            </tr>

            <tr>
                <td>
                    
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>" >
                    
                <input type="hidden" name="id" value="<?php echo $id; ?>" >
               
                <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
</table>
</form>
<?php 
    if(isset($_POST['submit'])){
        //1.Get all the details of form
        $id =$_POST['id'];
        $title=$_POST['title'];
        $description=$_POST['description'];
        $price= $_POST['price'];
        $current_image= $_POST['current_image'];
        $category = $_POST['category'];

        $featured =$_POST['featured'];
        $active =$_POST['active'];

        //2.Upload image if selected
            //check if Upload button is clicked or not
        if(isset($_FILES['image']['name'])){
            $image_name = $_FILES['image']['name'];

            if($image_name != ""){

                //Get the Extension of our image(jpg, png, gif, etc)food1.jpg Eg
                $ext = end(explode('.' , $image_name));

                //Rename the Image
                $image_name = "Food_Name.".rand(000, 999). '.'.$ext;

                $source_path= $_FILES['image']['tmp_name'];
                
               $destination_path ="../images/food/".$image_name;
  
                //Finally Upload the image
                $upload = move_uploaded_file($source_path,$destination_path);

                //Check whether the image is upload or not
                if($upload==false){

                    //Set message
                    $_SESSION['upload'] = "<div class='error'>Failed to upload Image. </div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                        //stop the process
                        die();
                }
                //3.Remove the oldimage and add new

                //B.Remove the current img
                if($current_image!=""){

                $remove_path = "../images/food/".$current_image;
                $remove = unlink($remove_path);

                //if failed to remove then display mes and stop the process
                if($remove==false){
                    $_SESSION['failed-remove'] = "<div class ='error'>Failed to remove current image</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die();
                }
            }
        }else{
            $image_name = $current_image;
        }
    }
        else{
            $image_name = $current_image;
        }
        
        //4.update the database
        $sql3= "UPDATE tbl_food SET
                        title='$title',
                        description = '$description',
                        price = $price,
                        image_name= '$image_name',
                        category_id = '$category',
                        featured='$featured',
                        active= '$active'
                        WHERE id =  $id
                    ";
                $res3 = mysqli_query($conn,$sql3);
        //5.redirect
        if($res3==true){
            $_SESSION['update'] = "<div class ='success'>Food Updated successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }else{
            $_SESSION['update'] = "<div class ='error'>Fail to update food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    
    
    
    ?>
                </div>
</div>
<?php include('partials/footer.php'); ?>