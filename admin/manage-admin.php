<?php include('partials/menu.php'); ?>
     <!-- main content section start-->
     <div class="main-content">
      <div class="wrapper">
   <h1>Manage Admin</h1>
     <br />

<?php 
     if(isset($_SESSION['add'])){
          echo $_SESSION['add'];//displaying session message
          unset($_SESSION['add']);//Removing session message
     }
     if(isset($_SESSION['delete'])){
          echo $_SESSION['delete'];
          unset($_SESSION['delete']);
     }
     if(isset($_SESSION['update'])){
          echo $_SESSION['update'];
          unset($_SESSION['update']);
     }
     if(isset($_SESSION['user-not-found'])){
          echo $_SESSION['user-not-found'];
          unset($_SESSION['user-not-found']);
     }
     if(isset($_SESSION['pwd-not-match'])){
          echo $_SESSION['pwd-not-match'];
          unset($_SESSION['pwd-not-match']);
     }
     if(isset($_SESSION['change-pwd'])){
          echo $_SESSION['change-pwd'];
          unset($_SESSION['change-pwd']);
     }
     ?>

<br><br><br>


   <!-- Button to add Admin-->
   <a href="add-admin.php" class="btn-primary">Add Admin</a>
   <br /> <br /> <br />
       <table class="tbl-full">
          <tr>
               <th>S.N.</th>
               <th>Fullname</th>
               <th>Username</th>
               <th>Actions</th>
               <th>Actions</th>
          </tr>
     <?php
     //Query to get all admin
     $sql= "SELECT * FROM tbl_admin";
     //Execute the query
     $res = mysqli_query($conn,$sql);
     //check whether the query is executed or not
     if($res==TRUE){
          //count rows to check whether we have data in database
          $count= mysqli_num_rows($res); // function to get all rows in databasse
          $sn=1; // create a variable and assign the value
          //check the num of rows
          if($count>0){
          //we have data
               while($rows=mysqli_fetch_assoc($res)){
                    //while loop will run as long as we have data in db

                    //get individual data
                    $id=$rows['id'];
                    $full_name=$rows['full_name'];
                    $username=$rows['username'];
                    //Display the value in our table
                    ?>
                    
               <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $username; ?></td>
                    <td>
                    <a href= "<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>"  class="btn-primary">Change Password</a>
                    <a href= "<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>"  class="btn-secondary">Update Admin</a>
                    <a href= "<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" 
                class="btn-danger">Delete Admin</a>
                    </td>
               </tr>
                 <?php   
               }
          }
          else{
          //we don't have data
          }
     
     }
     ?>
       </table>
     </div>
</div>
     <!-- main content section end-->
     <?php include('partials/footer.php');?>