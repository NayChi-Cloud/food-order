<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
    <h1>Update Admin</h1>
 
    <br><br>

<?php    
        //1.get the id of selected id
        $id=$_GET['id'];
        //2.Create SQLQuery to get details
        $sql="SELECT * FROM tbl_admin WHERE id=$id";
        //3.Execute the Query
        $res=mysqli_query($conn,$sql);
        //Check whether the query is exexuted or not
        if($res==true){
            $count= mysqli_num_rows($res);
            if($count==1){
                //Get the details
               $row=mysqli_fetch_assoc($res);

               $full_name= $row['full_name'];
               $username =$row['username'];
            }
            else{
                //Redirect to manage page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

        ?>


    <form action="" method="POST">
    <table class="tbl-30">
            <tr>
                <td>Full Name</td>
                <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"/>
            </td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php echo $username; ?>"/>
            </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name ="submit" value="Upate Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
        
    </form>
</div>
</div>
<?php 
//check the submit button is clicked or not

if(isset($_POST['submit'])){
    //Get all the value to update
    $id= $_POST['id'];
     $full_name= $_POST['full_name'];
    $username= $_POST['username'];
    

    //create SQL Query toupdate Admin
    $sql="UPDATE tbl_admin SET
    full_name= '$full_name',
    username= '$username'
    WHERE id ='$id'
    ";

    //Execute the Query
    $res= mysqli_query($conn,$sql);
    //check query executed sucesssfully or not
    if($res==true){
        //query executed and addmin updated
        $_SESSION['update'] ="<div class= 'success'>Admin Updated Successfully.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        $_SESSION['update'] ="<div class= 'error'>Faield to Update Admin.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    }



?>


<?php include('partials/footer.php'); ?>






