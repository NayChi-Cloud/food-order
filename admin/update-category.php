<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
    <?php 
        //Check whether the id is set or not
        if(isset($_GET['id'])){
            //Get the ID and all other details
           $id = $_GET['id'];
           
           //Create Query
           $sql = "SELECT * FROM tbl_category WHERE id= $id";
          
           //Execute Query
           $res= mysqli_query($conn,$sql);

           //Count the row to check id is valid or nor
           $count = mysqli_num_rows($res);

            if($count == 1){

                //Get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }else{

                //redirect to the page
                $_SESSION['no-category-found'] = "<div class='error'>Category Not found.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');

            }



    } else{
        //redirect to the Manage Category 
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    
    
        ?>



        <form action = "" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"/>
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
                                <img src ="<?php echo SITEURL; ?>images/category<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td> 
                        <input type="file" name="image">
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
                <td><input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"/>Yes
                    <input  <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No"/>No
            </td>
            
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>" >
                    <input type="hidden" name="id" value="<?php echo $id; ?>" >
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
</td>
            </tr>
            </table>
</form>
                <?php
                if (isset($_POST['submit'])){
                    $title= $_POST['title'];
                    $id = $_POST['id'];
                    $current_image = $_POST['current_image'];
                    $featured =$_POST['featured'];
                    $active =$_POST['active'];
                    
                    //2.Updating the img if selected
                    if(isset($_FILES['image']['name'])){

                        //Get the image detail
                        $image_name = $_FILES['image']['name'];
                        
                        //Check if img is avaliable or not
                        if($image_name != ""){
                           //A.Upload the new img

                        //Auto Rename our image
                //Get the Extension of our image(jpg, png, gif, etc)food1.jpg Eg
                $ext = end(explode('.' , $image_name));

                //Rename the Image
                $image_name = "Food_Category_".rand(000, 999). '.'.$ext;

                $source_path= $_FILES['image']['tmp_name'];
                
                $destination_path ="../images/category/".$image_name;
                
                //Finally Upload the image
                $upload = move_uploaded_file($source_path,$destination_path);

                //Check whether the image is upload or not
                if($upload==false){

                    //Set message
                    $_SESSION['upload'] = "<div class='error'>Failed to upload Image. </div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                        //stop the process
                        die();
                }
                //B.Remove the current img
                if($current_image!=""){
                $remove_path = "../images/category/".$current_image;
                $remove = unlink($remove_path);

                //if failed to remove then display mes and stop the process
                if($remove==false){
                    $_SESSION['failed-remove'] = "<div class ='error'>Failed to remove current image</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    die();
                }
            }
            }

                 else{
                            $image_name = $current_image;
                        }

                    }else{
                        $image_name = $current_image;
                    }


                    //3. Update the database
                 $sql2= "UPDATE tbl_category SET
                        title='$title',
                        image_name= '$image_name',
                        featured='$featured',
                        active= '$active'
                        WHERE id =  $id;
                    ";
                $res2 = mysqli_query($conn,$sql2);

                    //4.Redirect page
                    if($res2==true){
                        $_SESSION['update'] = "<div class ='success'>Category Updated successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }else{
                        $_SESSION['update'] = "<div class ='error'>Fail to update category.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                }
                
                
                
                ?>



    </div>
</div>
<?php include('partials/footer.php');
?>