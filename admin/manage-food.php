<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
    <h1>Manage Food</h1>
    <br />
    <!-- Button to add Food-->
   <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
   <br /> <br /> <br />
   <?php 
     if(isset($_SESSION['add'])){
          echo $_SESSION['add'];
          
          unset($_SESSION['add']);
     }
     if(isset($_SESSION['delete'])){
          echo $_SESSION['delete'];
          
          unset($_SESSION['delete']);
     }
     if(isset($_SESSION['upload'])){
          echo $_SESSION['upload'];
          
          unset($_SESSION['upload']);
     }
     if(isset($_SESSION['unauthorize'])){
          echo $_SESSION['unauthorize'];
          
          unset($_SESSION['unauthorize']);
     }
     if(isset($_SESSION['update'])){
          echo $_SESSION['update'];
          
          unset($_SESSION['update']);
     }
     ?>
       <table class="tbl-full">
          <tr>
               <th>S.N.</th>
               <th>Title</th>
               <th>Price</th>
               <th>Image</th>
               <th>Featured</th>
               <th>Active</th>
               <th>Actions</th>
          </tr>
          <?php
          //Create a SQL Query to get all the food
          $sql = "SELECT * FROM tbl_food";

          //Exeute Query
          $res= mysqli_query($conn,$sql);

          //Create Serial number variable
          $sn=1;
               //count Rows
          $count = mysqli_num_rows($res);

          //Check whether we have data in database
          if($count>0){
               //Have data
               //get the data and display
               while($row=mysqli_fetch_assoc($res))
               {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price =$row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>

                    <tr>
                         <td><?php echo $sn++; ?></td>
                         <td><?php echo $title; ?></td>
                         <td><?php echo $price; ?></td>
                         <td>

                         <?php //check whether the image name is avaliable or not
                         if($image_name==""){
                              //Display the Image
                              echo "<div class='error'>Image Not Added.</div>";
                         }else{
                              ?>
                              <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name;?> " width="100px" height="100px">
                              <?php
                         }
               ?>
          
                    </td>
                         <td><?php echo $featured; ?></td>
                         <td><?php echo $active; ?></td>
                         <td>
                              <a href= "<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"  class="btn-secondary">Update food</a>
                              <a href= "<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"  class="btn-danger">Delete food</a>
                         </td>
          </tr>
          <?php
                    
               }
          }
          else 
          {
               //food not added to database
               echo "<tr><td colspan = '7' class='error'>No Food Added Yet. </td></tr>";
          }
                    ?>
          



       </table>
</div>
</div>
<?php include('partials/footer.php')?>