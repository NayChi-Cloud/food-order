<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br /><br />
        <?php 
     if(isset($_SESSION['add'])){
          echo $_SESSION['add'];//displaying session message
          
          unset($_SESSION['add']);//Removing session message
     }
     if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
   }
?>



        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td><input type="text" name="title" placeholder="Category Title"/>
            </td>
            </tr>
     <tr>
        <td>Select Image:</td>
            <td>
                <input type="file" name="image">
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
                    <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>
<?php 
//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //1Get the value from Category Form
    $title= $_POST['title'];

    //for Radio input,we need to check whether the button is selected or not
    if(isset($_POST['featured'])){
        //get the value
        $featured = $_POST['featured'];
    }
    else{ 
        //Set the default value
       $featured = "No";

    }
    if(isset($_POST['active'])){
        //get the value
        $active = $_POST['active'];
    }
    else{ 
        //Set the default value
       $active = "No";
    } 
    //Check whether the image is selected or not and set the value for image name accordingly
    
    if(isset($_FILES['image']['name'])){
    //Upload the image name,source path and desitnation path
       
        $image_name= $_FILES['image']['name'];
        //upload the image only if image is selected
        if($image_name != "")
        {

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
             header('location:'.SITEURL.'admin/add-category.php');
                //stop the process
                die();
        }
    }
}
    else{
        //Don't upload image and set the image_name value as blank
        $image_name="";
    }
//2. Creaate SQL query to insert category into database
$sql= "INSERT INTO tbl_category SET
       title='$title',
       image_name='$image_name',
       featured='$featured',
       active= '$active' 
       ";
//3.Exectue sql Query and save in database
$res = mysqli_query($conn,$sql);
//4.check whether the query is executed or not and data added or not
if($res==true){
    //query added and Category Added
    $_SESSION['add'] = "<div class='success'>
    Category added Successful.</div>";
    //Redirect to Home page
    header('location:'.SITEURL.'admin/manage-category.php');
}else{
    //Failed to Add Category
    $_SESSION['add'] = "<div class='error text-center'>
     Failed to add category.</div>";
    //Redirect to Home page
    header('location:'.SITEURL.'admin/manage-category.php');
    }
}
?>
</div>
</div>




<?php include('partials/footer.php'); ?>
